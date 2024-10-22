<template>
    <div>
        <Loader v-if="loading" text="Загрузка модели..."/>
        <FullScreenButton @click="toggleFullscreen"/>
        <div ref="container">
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

const buildingMaterial = new THREE.MeshStandardMaterial({
    color: 0xe5e7eb,
    opacity: 0.05,
    transparent: true,
    side: THREE.DoubleSide,
    wireframe: true,
    depthWrite: false,
});

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
            velocity: new THREE.Vector3(), // Скорость перемещения камеры
        };
    },
    mounted() {
        this.mouse = new THREE.Vector2();
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

            this.camera = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 0.1, 1000);
            this.camera.position.set(0, 2, 10);

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
                    this.buildingDetails.push(model);
                } else {
                    const vue = this;
                    model.traverse(function (child) {
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
            const rect = this.$refs.modelContainer.getBoundingClientRect();
            this.mouse.x = ((event.clientX - rect.left) / rect.width) * 2 - 1;
            this.mouse.y = -((event.clientY - rect.top) / rect.height) * 2 + 1;
            this.raycaster.setFromCamera(this.mouse, this.camera);
            const intersects = this.raycaster.intersectObjects(this.scene.children, true);
            if (intersects.length > 0) {
                const intersectedObject = intersects[0].object;
                if (intersectedObject.isMesh) {
                    this.buildingDetails.forEach((d) => d.material.color.set('#e5e7eb'));
                    intersectedObject.material.color.set('#ff7200');
                    this.selectedObjectName = intersectedObject.name || 'Unnamed Object';
                    //this.showModal = true;
                    console.log('Clicked on:', intersectedObject);
                    const boundingBox = new THREE.Box3().setFromObject(intersectedObject);

                // Выводим в консоль размеры объекта
                    const size = new THREE.Vector3();
                    boundingBox.getSize(size);
                    console.log(`Размеры объекта: x=${size.x}, y=${size.y}, z=${size.z}`);
                }
            }
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
    },
};
</script>

<style scoped>
.model-container {
    width: 100%;
    height: 100vh;
}

.modal {
    display: block;
    position: fixed;
    z-index: 1000;
    right: 1%;
    top: 10%;
    transform: translate(-50%, -50%);
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
</style>
