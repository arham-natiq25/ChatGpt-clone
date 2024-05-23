<script setup>
    import ChatLayout from './../../Layouts/ChatLayout.vue'
    import Skeleton from './../../Components/Skeleton.vue'
    import { useForm,Link } from '@inertiajs/vue3';
    import {Head} from '@inertiajs/vue3';
    import ChatContent from "./../../Components/ChatContent.vue";
    import { onMounted, ref } from 'vue';
    const form=useForm({
        prompt:""
    })

    const submit = ()=>{
        const url = props.chat ? `/chat/${props.chat?.id}` : '/chat'
        form.post(url   )
    }
    const props=defineProps({
        message:Array,
        chat:null | Object
    })
    const promptInput = ref(null);
    const chatContainer = ref(null);

    const scrollToBottom = ()=>{
        if (props.chat) {
            const el =  chatContainer.value;
           el.scrollTop = el.scrollHeight;
        }
    }

    const clear = ()=>{
        form.prompt="";
        promptInput.value.focus();
        scrollToBottom();
    }
    onMounted(()=>{
        clear()
    })

</script>
<template>
    <ChatLayout>
        <template #aside>
            <ul class="p-2">
                <li
                v-if="chat"
                class="px-4 py-2 my-2 flex justify-between font-semibold text-green-400 bg-slate-900 hover:bg-slate-700 rounded-lg duration-200"
            >
                <Link href="/chat" class="w-full">New Chat</Link>
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 4.5v15m7.5-7.5h-15"
                    />
                </svg>
            </li>
                <template v-for="mess in message" :key="mess.id">
                    <li

                     class="px-4 py-2 flex justify-between font-semibold text-slate-400 bg-slate-900 hover:bg-slate-700 rounded-lg duration-200">
                        <Link :href="`/chat/${mess.id}`">
                        {{ mess.context[0].content }}
                        </Link>

                    </li>
                </template>
            </ul>
        </template>
        <div class="w-full flex text-white">
            <template v-if="chat" >
                <div class="w-full flex h-screen bg-slate-900">
                    <div class="w-full overflow-auto px-6 py-4 mb-[10%] bg-slate-800" ref="chatContainer">
                        <template
                            v-for="(content, index) in chat?.context"
                            :key="index"
                        >
                            <ChatContent :content="content"/>
                        </template>
                        <Skeleton v-show="form.processing" class="mt-4"/>
                    </div>
                </div>
            </template>
        </div>
        <template #form>
            <section class="px-6 top-0">
                <div class="w-full">
                    <div class="relative flex-1 flex flex-items-center">
                        <input type="text" name="" class="w-full bg-slate-700 text-white rounded-lg"
                            placeholder="Ask Laravel AI" id="" v-model="form.prompt"
                            @keyup.enter="submit"
                            :disabled="form.processing"
                            ref="promptInput"
                            >
                        <div class="absolute insert-y-0 right-0 flex items-center pl-3 mt-2">
                            <svg
                            v-if="!form.processing"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6 -ml-8 text-slate-200">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                            </svg>
                            <div class="dot-typing -ml-10 " v-if="form.processing">

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </template>
    </ChatLayout>

</template>
<style>
.dot-typing {
    position: relative;
    left: -9999px;
    width: 10px;
    height: 10px;
    border-radius: 5px;
    background-color: #9880ff;
    color: #9880ff;
    box-shadow: 9984px 0 0 0 #9880ff, 9999px 0 0 0 #9880ff,
        10014px 0 0 0 #9880ff;
    animation: dot-typing 1.5s infinite linear;
}
@keyframes dot-typing {
    0% {
        box-shadow: 9984px 0 0 0 #9880ff, 9999px 0 0 0 #9880ff,
            10014px 0 0 0 #9880ff;
    }
    16.667% {
        box-shadow: 9984px -10px 0 0 #9880ff, 9999px 0 0 0 #9880ff,
            10014px 0 0 0 #9880ff;
    }
    33.333% {
        box-shadow: 9984px 0 0 0 #9880ff, 9999px 0 0 0 #9880ff,
            10014px 0 0 0 #9880ff;
    }
    50% {
        box-shadow: 9984px 0 0 0 #9880ff, 9999px -10px 0 0 #9880ff,
            10014px 0 0 0 #9880ff;
    }
    66.667% {
        box-shadow: 9984px 0 0 0 #9880ff, 9999px 0 0 0 #9880ff,
            10014px 0 0 0 #9880ff;
    }
    83.333% {
        box-shadow: 9984px 0 0 0 #9880ff, 9999px 0 0 0 #9880ff,
            10014px -10px 0 0 #9880ff;
    }
    100% {
        box-shadow: 9984px 0 0 0 #9880ff, 9999px 0 0 0 #9880ff,
            10014px 0 0 0 #9880ff;
    }
}
</style>
