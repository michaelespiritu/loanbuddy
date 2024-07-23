<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    username: '',
    email: '',
});


const submit = () => {
    form.clearErrors()
    form.post(route('barrower.create.user'), {
        onSuccess: () => {
            form.reset()
        }
    });
};

</script>

<template>
    <Head title="Create Barrower" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Barrower</h2>
        </template>

        <div class="py-12" >
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">
                <h4>Barrower Personal Information</h4>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <div class="mb-5">
                        <InputLabel for="name" value=" Name" />

                        <TextInput
                            id="name"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.name"
                            required
                        />

                        <InputError class="mt-2" :message="form.errors.name" />

                    </div>

                    <div class="mb-5">
                        <InputLabel for="username" value="Username" />

                        <TextInput
                            id="name"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.username"
                            required
                        />

                        <InputError class="mt-2" :message="form.errors.username" />

                    </div>

                    <div class="mb-5">
                        <InputLabel for="email" value="Email" />

                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            required
                        />

                        <InputError class="mt-2" :message="form.errors.email" />

                    </div>

                    <div class="mt-6 flex justify-end items-center">

                        <div  v-if="form.wasSuccessful">
                            <Transition
                                enter-active-class="transition ease-in-out"
                                enter-from-class="opacity-0"
                                leave-active-class="transition ease-in-out"
                                leave-to-class="opacity-0"
                            >
                                <p class="text-sm text-gray-600 ml-3">Saved.</p>
                            </Transition>
                        </div>
                        <div v-else> 
                            <SecondaryButton 
                                v-if="! form.processing"
                                @click="emit('closeModal', false)">
                                Cancel
                            </SecondaryButton>

                            <PrimaryButton
                                class="ms-3"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                                @click="submit"
                            >
                                Create Barrower
                            </PrimaryButton>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
