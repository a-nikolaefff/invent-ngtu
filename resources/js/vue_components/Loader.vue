<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="flex flex-col items-center space-y-4">
            <div class="loader bg-blue-500"></div>
            <p class="text-gray-700 font-semibold">{{ text }}</p>
        </div>
    </div>
</template>

<script>
export default {
    name: "Loader",
    props: {
        text: {
            type: String,
            required: true,
            default: 'Загрузка...'
        },
    }
};
</script>

<style scoped>
.loader {
    border: 8px solid rgba(0, 0, 0, 0.1);
    border-left-color: #3490dc;
    border-radius: 50%;
    width: 48px;
    height: 48px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>
