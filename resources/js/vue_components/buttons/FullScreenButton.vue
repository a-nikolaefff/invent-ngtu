<template>
    <button class="mr-2 mb-3 text-black-600 border-2
    border-black-600 inline-block rounded px-6 pb-2 pt-2.5 text-sm
    font-medium leading-normal shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150
    ease-in-out hover:bg-gray-900 hover:border-black-600 hover:text-white
    hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]
    active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]">
        <span class="flex">
               <svg class="h-6 w-6 text-slate-900"  width="24" height="24" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>
                   <polyline points="16 4 20 4 20 8" />  <line x1="14" y1="10" x2="20" y2="4" />
                   <polyline points="8 20 4 20 4 16" />  <line x1="4" y1="20" x2="10" y2="14" />
                   <polyline points="16 20 20 20 20 16" />  <line x1="14" y1="14" x2="20" y2="20" />
                   <polyline points="8 4 4 4 4 8" />  <line x1="4" y1="4" x2="10" y2="10" />
               </svg>
            <span class="inline-block pl-2">
                ПОЛНОЭКРАННЫЙ РЕЖИМ
            </span>

        </span>




    </button>
</template>

<script lang="ts">
import {defineComponent} from 'vue'

export default defineComponent({
    name: "FullScreenButton"
})
</script>
