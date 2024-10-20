<x-layouts.app :centered="true" :title="'3D модель'">
    <div class="content-block">
        <style>
        html, body {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        }
        #modelContainer {
        width: 100vw;
        height: 100vh;
        position: relative;
        }
        #fullscreenButton {
        position: absolute;
        top: 20px;
        right: 20px;
        padding: 10px 15px;
        background-color: rgba(0, 0, 0, 0.8);
        color: #fff;
        border: none;
        cursor: pointer;
        font-size: 16px;
        z-index: 1000;
        }
        </style>

        <div id="modelContainer"></div>
        <button id="fullscreenButton">Fullscreen</button>

    </div>
</x-layouts.app>
