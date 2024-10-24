<template>
    <div>
        <Loader v-if="loading" text="Загрузка модели..."/>
        <FullScreenButton class="fullscreen-button" @click="toggleFullscreen"/>
        <div ref="container" class="common-container">
            <div ref="modelContainer" class="model-container"></div>
            <div v-if="showModal" class="modal">
                <div class="modal-content">
                    <span class="close" @click.stop="closeModal">&times;</span>
                    <p>Object Name: {{ selectedObjectName }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import * as THREE from 'three';
import { ArcballControls } from 'three/examples/jsm/controls/ArcballControls.js';
import { FBXLoader } from 'three/examples/jsm/loaders/FBXLoader.js';
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader.js';
import { OBJLoader } from 'three/examples/jsm/loaders/OBJLoader.js';
import FullScreenButton from "./buttons/FullScreenButton.vue";
import Loader from "./Loader.vue";
import {Vector2} from "three";

const buildingMaterial = new THREE.MeshStandardMaterial({
    color: 0xe5e7eb,
    opacity: 0.05,
    transparent: true,
    side: THREE.DoubleSide,
    wireframe: true,
    depthWrite: false,
});

const defaultRoomColor = 0x000000;
const elementOpacity = 0.4;

export default {
    name: 'ThreeDModel',
    components: {Loader, FullScreenButton },
    props: {
        modelPath: {
            type: String,
            required: true,
        },
        modelScale: {
            required: true,
        },
        rooms: {
            type: Array
        }
    },
    data() {
        return {
            loading: true,
            buildingDetails: [],
            showModal: false,
            selectedObjectName: '',
            isFirstPerson: false,  // Управление режимом от первого лица
            controls: null, // Управление камерой
            moveForward: false,
            moveBackward: false,
            moveLeft: false,
            moveRight: false,
            velocity: new THREE.Vector3(),
            mouse: new THREE.Vector2(),
            roomObjects: [],
            equipmentObjects: [],
        };
    },
    mounted() {
        this.initScene();
        this.loadModel();
        window.addEventListener('resize', this.onWindowResize);
        window.addEventListener('click', this.onMouseClick);
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.onWindowResize);
        window.removeEventListener('click', this.onMouseClick);
    },
    methods: {
        initScene() {
            this.scene = new THREE.Scene();
            this.scene.background = new THREE.Color(0xf3f4f6);

            this.camera = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 0.1, 5000);
            this.camera.position.set(0, 2, 10);

            this.camera.layers.enable(1);  // Включаем слой 1 для здания
            this.camera.layers.enable(2);

            this.renderer = new THREE.WebGLRenderer({ antialias: true });
            this.renderer.setSize(window.innerWidth, window.innerHeight);
            this.renderer.setPixelRatio(window.devicePixelRatio);
            this.$refs.modelContainer.appendChild(this.renderer.domElement);

            const ambientLight = new THREE.AmbientLight(0x000000);
            this.scene.add(ambientLight);

            // Инициализация ArcballControls
            this.controls = new ArcballControls(this.camera, this.renderer.domElement, this.scene);

            this.controls.enableZoom = true;

            this.controls.cursorZoom = true;

            this.raycaster = new THREE.Raycaster();
            this.animate();
        },
        loadModel() {
            const modelPath = this.modelPath;
            const loader = this.getModelLoader(modelPath);
            loader.load(modelPath, (model) => {
                const scale = this.modelScale ?? 1
                model.scale.set(scale, scale, scale);
                if (model.isMesh) {
                    model.material = buildingMaterial;
                    model.layers.set(1);
                    this.buildingDetails.push(model);
                } else {
                    const vue = this;
                    model.traverse(function (child) {
                        child.layers.set(1);
                        if (child.isMesh) {
                            vue.buildingDetails.push(child);
                            child.material = buildingMaterial.clone();
                        }
                    });
                }
                this.scene.add(model);
                this.loading = false


                const cubeGeometry = new THREE.BoxGeometry(5, 5, 5);
                const cubeMaterial = new THREE.MeshStandardMaterial({ color: 0x00ff00, opacity: 0.7, transparent: true });
                const cube = new THREE.Mesh(cubeGeometry, cubeMaterial);
                cube.position.set(22.5, 95, -10); // Поднимаем его на 0.5 метра, чтобы основание было на уровне земли
                this.scene.add(cube);
                this.drawRooms()

                this.renderer.render(this.scene, this.camera);
            });
        },
        getModelLoader(modelPath) {
            const extension = modelPath.split('.').pop().toLowerCase();
            if (extension === 'fbx') {
                return new FBXLoader();
            } else if (extension === 'obj') {
                return new OBJLoader();
            } else if (extension === 'gltf' || extension === 'glb') {
                return new GLTFLoader();
            }
            return null;
        },
        onWindowResize() {
            this.camera.aspect = window.innerWidth / window.innerHeight;
            this.camera.updateProjectionMatrix();
            this.renderer.setSize(window.innerWidth, window.innerHeight);
        },
        onMouseClick(event) {
            const rect = this.renderer.domElement.getBoundingClientRect();

            const x = ((event.clientX - rect.left) / rect.width ) *  2 - 1;
            const y = ((event.clientY - rect.top) / rect.height) * - 2 + 1;
            const mouse = new Vector2(x, y)

            this.raycaster.layers.set(2);
            this.raycaster.setFromCamera(mouse, this.camera);

            const intersects = this.raycaster.intersectObjects(this.roomObjects, false);
            if (intersects.length > 0) {
                const intersectedObject = intersects[0].object;
                if (intersectedObject.isMesh) {
                    this.selectObject(intersectedObject)
                }
            } else {
               this.deselectObjects()
            }
        },
        selectObject(obj) {
            obj.material.opacity = 1
            this.selectedObjectName = obj.userData.name || 'Unnamed Object';
            this.showModal = true;
        },
        deselectObjects() {
            this.showModal = false
            const allObjects = this.roomObjects.concat(this.equipmentObjects);
            allObjects.forEach((obj) => {
                obj.material.opacity = elementOpacity
            })
        },
        animate() {
            requestAnimationFrame(this.animate);
            this.controls.update()
            this.renderer.render(this.scene, this.camera);
        },
        toggleFullscreen() {
            const container = this.$refs.container;
            if (!document.fullscreenElement) {
                container.requestFullscreen();
            } else {
                document.exitFullscreen();
            }
        },
        closeModal() {
            this.showModal = false;
        },
        drawRooms() {
            const vue = this;
            this.rooms.forEach((room) => {
                const geometry = vue.normalizeGeometry(room.geometry)
                const color = room?.type?.model_color
                    ? vue.normalizeColor(room.type.model_color)
                    : defaultRoomColor
                const roomObject = vue.drawElement(geometry, color)
                vue.roomObjects.push(roomObject)
            })
        },
        normalizeGeometry(geometry) {
            if (geometry.anchor_point) {
                geometry.anchor_point.x /= 1000;
                geometry.anchor_point.y /= 1000;
                geometry.anchor_point.z /= 1000;
            }
            if (geometry.base_points && Array.isArray(geometry.base_points)) {
                geometry.base_points = geometry.base_points.map(point => ({
                    x: point.x / 1000,
                    y: point.y / 1000
                }));
            }
            if (geometry.height) {
                geometry.height /= 1000;
            }
            return geometry;
        },
        normalizeColor(color) {
            return parseInt(color.slice(1), 16);
        },
        drawElement(geometry, color) {
            const shape = new THREE.Shape();
            const initPoint = geometry.base_points[0]
            shape.moveTo(initPoint.x, initPoint.y);
            geometry.base_points.forEach((p, i) => {
                if (i === 0) return
                shape.lineTo(p.x, p.y);
            })
            shape.lineTo(initPoint.x, initPoint.y);

            const material = new THREE.MeshBasicMaterial({
                color: color,
                transparent: true,
                opacity: elementOpacity,
                side: THREE.DoubleSide
            });

            const mesh = new THREE.Mesh(new THREE.ExtrudeGeometry(shape, {
                depth: geometry.height,
                bevelEnabled: false
            }), material);
            mesh.userData = { name: 'Комната 1' };
            mesh.position.set(geometry.anchor_point.x, geometry.anchor_point.y, geometry.anchor_point.z);

            mesh.layers.set(2)
            this.scene.add(mesh);

            return mesh;
        }
    },
};
</script>

<style scoped>
.model-container {
    width: 100%;
    height: 100vh;
}
.common-container {
    position: relative;
}
.modal {
    display: block;
    position: absolute;
    z-index: 1000;
    right: 1%;
    top: 8%;
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.modal-content {
    padding: 20px;
    text-align: center;
}

.close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 20px;
    cursor: pointer;
}

.toggle-button {
    position: absolute;
    top: 10px;
    left: 10px;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}

.toggle-button:hover {
    background-color: #45a049;
}
.fullscreen-button {
    user-select: none; /* Отключает возможность выделения текста */
}
</style>
