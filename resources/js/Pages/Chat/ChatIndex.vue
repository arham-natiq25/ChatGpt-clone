<script setup>
    import ChatLayout from './../../Layouts/ChatLayout.vue'
    import { useForm,Link } from '@inertiajs/vue3';
    import ChatContent from "./../../Components/ChatContent.vue";
    const form=useForm({
        prompt:""
    })

    const submit = ()=>{
        form.post('/chat')
    }
    const props=defineProps({
        message:Array,
        chat:null | Object
    })

</script>
<template>
    <ChatLayout>

        <template #aside>
            <ul class="p-2">
                <template v-for="mess in message" :key="mess.id">
                    <li class="px-4 py-2 flex justify-between font-semibold text-slate-400 bg-slate-900 hover:bg-slate-700 rounded-lg duration-200">
                        <Link :href="`/chat/${mess.id}`">
                        {{ mess.context[0].content }}
                        </Link>

                    </li>
                </template>
            </ul>
        </template>
        <div class="w-full flex text-white">
            <template v-if="chat">
                <div class="w-full flex h-screen bg-slate-900">
                    <div class="w-full overflow-auto">
                        <template
                            v-for="(content, index) in chat?.context"
                            :key="index"
                        >
                            <ChatContent :content="content" />
                        </template>
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
                            >
                        <div class="absolute insert-y-0 right-0 flex items-center pl-3 mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6 -ml-8 text-slate-200">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                            </svg>
                        </div>
                    </div>
                </div>
            </section>
        </template>
    </ChatLayout>

</template>
