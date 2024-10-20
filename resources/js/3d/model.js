import * as THREE from 'three';
import { ArcballControls } from 'three/examples/jsm/controls/ArcballControls';
import { TrackballControls } from 'three/addons/controls/TrackballControls.js';
import {FBXLoader, GLTFLoader, OBJLoader} from "three/addons";


    // Инициализация сцены, камеры и рендера
    const scene = new THREE.Scene();
    scene.background = new THREE.Color(0xf3f4f6)
    const camera = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 0.25, 1000);
    // Позиционирование камеры
    camera.position.set(0, 2, 10);
    camera.lookAt(new THREE.Vector3(0, 0, 0));


    const renderer = new THREE.WebGLRenderer();

    // Получаем контейнер для рендера и добавляем туда canvas
    const container = document.getElementById('modelContainer');
    container.appendChild(renderer.domElement);

    renderer.setSize(container.clientWidth, container.clientHeight);
    renderer.setPixelRatio(window.devicePixelRatio);
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.toneMapping = THREE.ACESFilmicToneMapping;
    renderer.toneMappingExposure = 1;
    renderer.outputEncoding = THREE.sRGBEncoding;

    // Добавляем освещение
    const light = new THREE.DirectionalLight(0xffffff, 1);
    light.position.set(10, 10, 10);
    scene.add(light);

    const ambientLight = new THREE.AmbientLight(0x404040); // мягкий белый свет
    scene.add(ambientLight);

    // Подключение TrackballControls
    const controls = new ArcballControls(camera, renderer.domElement, scene);

// Настройки управления
controls.rotateSpeed = 1.0;
controls.zoomSpeed = 1.2;
controls.panSpeed = 0.8;
controls.noZoom = false;
controls.noPan = false;
controls.staticMoving = true;
controls.dynamicDampingFactor = 0.3;
controls.adjustNearFar = true

// Переменные для управления камерой с помощью клавиш
let moveForward = false;
let moveBackward = false;
let moveLeft = false;
let moveRight = false;
const moveSpeed = 0.1;

// Обработчик нажатия клавиш
document.addEventListener('keydown', (event) => {
    switch (event.code) {
        case 'ArrowUp':   // Вверх
            moveForward = true;
            break;
        case 'ArrowDown': // Вниз
            moveBackward = true;
            break;
        case 'ArrowLeft': // Влево
            moveLeft = true;
            break;
        case 'ArrowRight': // Вправо
            moveRight = true;
            break;
    }
});

// Обработчик отпускания клавиш
document.addEventListener('keyup', (event) => {
    switch (event.code) {
        case 'ArrowUp':
            moveForward = false;
            break;
        case 'ArrowDown':
            moveBackward = false;
            break;
        case 'ArrowLeft':
            moveLeft = false;
            break;
        case 'ArrowRight':
            moveRight = false;
            break;
    }
});

// Обновление позиции камеры на основе нажатых клавиш
function updateCameraPosition() {
    if (moveForward) camera.translateZ(-moveSpeed);
    if (moveBackward) camera.translateZ(moveSpeed);
    if (moveLeft) camera.translateX(-moveSpeed);
    if (moveRight) camera.translateX(moveSpeed);
}

    // Увеличьте maxDistance, чтобы камера могла свободно удаляться
    //controls.minDistance = 0.1;  // Минимальное расстояние
    //controls.maxDistance = 500;  // Максимальное расстояние для свободного движения камеры

    // Дополнительно, если нужно вращать по всем осям:
    controls.enableRotate = true;
    controls.enableZoom = true;
    controls.enablePan = true;

    controls.mouseButtons = {
    LEFT: THREE.MOUSE.ROTATE,
    MIDDLE: THREE.MOUSE.DOLLY,
    RIGHT: THREE.MOUSE.PAN
};


    // Определение типа модели (FBX, OBJ, GLTF)
    const modelPath = '/storage/model/korpus6.fbx'; // Замените на реальный путь
    const modelExtension = modelPath.split('.').pop().toLowerCase();

    function loadModel() {
    if (modelExtension === 'fbx') {
    loadFBX(modelPath);
} else if (modelExtension === 'obj') {
    loadOBJ(modelPath);
} else if (modelExtension === 'gltf' || modelExtension === 'glb') {
    loadGLTF(modelPath);
} else {
    console.error('Unsupported model format: ' + modelExtension);
}
}

    // Загрузчик для FBX
    function loadFBX(path) {
    const loader = new FBXLoader();

    const transparentMaterial = new THREE.MeshStandardMaterial({
    color: 0xe5e7eb,  // Цвет здания (например, зелёный)
    opacity: 0.15,     // Полупрозрачность
    transparent: true, // Включение прозрачности
    side: THREE.DoubleSide, // Отображение обеих сторон стен
/*    roughness: 0.5,  // Регулирует шероховатость поверхности
    metalness: 0.1,  // Регулирует металлический блеск*/
    depthWrite: false,
});

    loader.load(path, function (model) {
    model.scale.set(1, 1, 1);
    model.position.set(0, 0, 0);

    if (model.isMesh) {
    model.material = transparentMaterial

    /*model.material.transparent = true;
    model.material.opacity = 0.25;
    model.material.depthWrite = false;*/
} else {

    model.traverse(function (child) {
    if (child.isMesh) {
    child.material = transparentMaterial
    /*child.material.transparent = true;
    child.material.opacity = 0.25;
    child.material.depthWrite = false;*/
}
});
}

    scene.add(model);

        // Вычисляем границы модели
        const boundingBox = new THREE.Box3().setFromObject(model);

        // Вычисляем размер и центр модели
        const size = new THREE.Vector3();
        boundingBox.getSize(size);
        const center = new THREE.Vector3();
        boundingBox.getCenter(center);

        // Устанавливаем камеру так, чтобы была видна вся модель
        const maxDim = Math.max(size.x, size.y, size.z);
        const fov = camera.fov * (Math.PI / 180); // Преобразование FOV в радианы
        let cameraZ = Math.abs(maxDim / (2 * Math.tan(fov / 2)));

        // Считаем расстояние до модели с учетом ближайшей и дальней плоскости камеры
        const minZ = boundingBox.min.z;
        const cameraToFarEdge = Math.abs(minZ) + cameraZ;

        //camera.position.set(center.x, center.y, cameraZ);
        //camera.lookAt(center);


        // Рендеринг сцены
        renderer.render(scene, camera);
}, undefined, function (error) {
    console.error('Ошибка загрузки FBX модели:', error);
});
}

    // Загрузчик для OBJ
    function loadOBJ(path) {
    const loader = new OBJLoader();
    loader.load(path, function (model) {
    model.scale.set(1, 1, 1);
    model.position.set(0, 0, 0);

    if (model.isMesh) {
    model.material.transparent = true;
    model.material.opacity = 0.5;
    model.material.depthWrite = false;
} else {
    model.traverse(function (child) {
    if (child.isMesh) {
    child.material.transparent = true;
    child.material.opacity = 0.5;
    child.material.depthWrite = false;
}
});
}

    scene.add( model);
    renderer.render(scene, camera);
}, undefined, function (error) {
    console.error('Ошибка загрузки OBJ модели:', error);
});
}

    // Загрузчик для GLTF/GLB
    function loadGLTF(path) {
    const loader = new GLTFLoader();
    loader.load(path, function (gltf) {
    gltf.scene.scale.set(0.5, 0.5, 0.5);
    gltf.scene.position.set(0, 0, 0);
    scene.add(gltf.scene);
    renderer.render(scene, camera);
}, undefined, function (error) {
    console.error('Ошибка загрузки GLTF модели:', error);
});
}




    // Обновление размера окна при изменении
    window.addEventListener('resize', function() {
    const width = container.clientWidth;
    const height = container.clientHeight;
    renderer.setSize(width, height);
    camera.aspect = width / height;
    camera.updateProjectionMatrix();
});

    // Блокируем скроллинг страницы при взаимодействии с моделью
    container.addEventListener('wheel', function(event) {
    event.preventDefault();
}, { passive: false });

    // Загрузка модели
    loadModel();

    // Инициализация Raycaster и вектора для мыши
    const raycaster = new THREE.Raycaster();
    const mouse = new THREE.Vector2();

    // Создание элемента для отображения описания
    const tooltip = document.createElement('div');
    tooltip.style.position = 'absolute';
    tooltip.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
    tooltip.style.color = '#fff';
    tooltip.style.padding = '5px';
    tooltip.style.borderRadius = '3px';
    tooltip.style.display = 'none';  // По умолчанию скрываем
    document.body.appendChild(tooltip);

    // Функция обновления тултипа
    function updateTooltip(intersectedObject, mouseX, mouseY) {
    const description = intersectedObject.userData.description;

    if (description) {
    tooltip.innerText = description;
    tooltip.style.left = `${mouseX - 10}px`;  // Смещаем на несколько пикселей вправо
    tooltip.style.top = `${mouseY + 120}px`;   // Смещаем вниз для удобства
    tooltip.style.display = 'block';
}
}

    let previousIntersectedObject = null;



    const roomShape = new THREE.Shape();
    roomShape.moveTo(0, 0);  // Точка 1 (x, y)
    roomShape.lineTo(0.5, 0);  // Точка 2
    roomShape.lineTo(0.5, 1);  // Точка 3 Длинная сторона
    roomShape.lineTo(0, 1);  // Точка 5
    roomShape.lineTo(0, 0);  // Замыкаем фигуру Длинная сторона

    const roomHeight = 10;  // Высота помещения
    const extrudeSettings = {
    depth: roomHeight,  // Высота вытягивания по оси Z
    bevelEnabled: false  // Без сглаживания углов
};

    const roomGeometry = new THREE.ExtrudeGeometry(roomShape, extrudeSettings);

    roomGeometry.rotateX(Math.PI / 2);  // В данном случае поворачиваем на 90 градусов

    const boundingBox = new THREE.Box3().setFromObject(new THREE.Mesh(roomGeometry));
    const heightOffset = boundingBox.min.z;  // Самая нижняя точка по оси Z

    // Создание материала для визуализации
    const material = new THREE.MeshBasicMaterial({
    color: 0x00ff00,  // Зелёный цвет
    transparent: true,
    opacity: 1,  // Полупрозрачность
    side: THREE.DoubleSide
});

    // Создание Mesh на основе геометрии
    const roomMesh = new THREE.Mesh(roomGeometry, material);
    roomMesh.userData = { description: 'Комната 1' };

    // Перемещаем фигуру так, чтобы основание находилось в точке (0, 0, 0)
    roomMesh.position.set(0, -heightOffset, 0);  // Смещаем на высоту основания

    roomGeometry.translate(0, roomHeight, 0);  // Поднимаем её на высоту

    // Теперь добавляем Mesh на сцену
    scene.add(roomMesh);

    // Создание материала для визуализации
    const material2 = new THREE.MeshBasicMaterial({
    color: 0x00ff00,  // Зелёный цвет
    transparent: true,
    opacity: 1,  // Полупрозрачность
    side: THREE.DoubleSide
});

    // Пример координат для произвольного основания (x, y) в плоскости XY
    const roomShape2 = new THREE.Shape();
    roomShape2.moveTo(0, 0);  // Точка 1 (x, y)
    roomShape2.lineTo(30, 0);  // Точка 2
    roomShape2.lineTo(30, 30);  // Точка 3 Длинная сторона
    roomShape2.lineTo(0, 30);  // Точка 5
    roomShape2.lineTo(0, 0);  // Замыкаем фигуру Длинная сторона

    // Создание 3D геометрии комнаты
    const roomGeometry2 = new THREE.ExtrudeGeometry(roomShape2, extrudeSettings);

    // Создание и добавление Mesh на сцену
    const roomMesh2 = new THREE.Mesh(roomGeometry2, material2);
    roomMesh2.userData = { description: 'Комната 2' };
    scene.add(roomMesh2);

    window.addEventListener('click', (event) => {
    const rect = container.getBoundingClientRect();  // Получаем размер и позицию контейнера
    mouse.x = ((event.clientX - rect.left) / rect.width) * 2 - 1;
    mouse.y = -((event.clientY - rect.top) / rect.height) * 2 + 1;
    raycaster.setFromCamera(mouse, camera);

    const intersects = raycaster.intersectObjects(scene.children, true);  // Проверяем пересечение с объектами

    if (intersects.length > 0) {
    const intersectedObject = intersects[0].object;

    if (intersectedObject instanceof THREE.Mesh
    && intersectedObject.userData.description
    && intersectedObject.material) {

    intersectedObject.material.color.set("#ff7200");
    updateTooltip(intersectedObject, event.clientX, event.clientY);
}
} else {
    roomMesh.material.color.set('#00ff00')
    roomMesh2.material.color.set('#00ff00')
    tooltip.style.display = 'none';  // Скрываем тултип
}
});

    // Анимация
    function animate() {
    requestAnimationFrame(animate);

        // Обновляем позицию камеры
        updateCameraPosition();

        // Обновляем ArcballControls

    renderer.render(scene, camera);
}
    animate();

const fullscreenButton = document.getElementById('fullscreenButton');

fullscreenButton.addEventListener('click', () => {
    if (!document.fullscreenElement) {
        container.requestFullscreen().catch(err => {
            alert(`Error attempting to enable fullscreen mode: ${err.message} (${err.name})`);
        });
    } else {
        document.exitFullscreen();
    }
});

window.addEventListener('resize', function() {
    const width = window.innerWidth;
    const height = window.innerHeight;
    renderer.setSize(width, height);
    camera.aspect = width / height;
    camera.updateProjectionMatrix();
});

