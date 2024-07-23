<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ButtonAsLink from '@/Components/ButtonAsLink.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    company_name: '',
    name: '',
    username: '',
    email: '',
    logo: '',
});

const submit = () => {
    form.clearErrors()
    form.post(route('company.store'), {
        onSuccess: () => {
            form.reset()
        }
    });
};


</script>

<template>
    <Head title="Create Company" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Company</h2>
                <ButtonAsLink :href="route('company.index')" :active="route().current('company.index')">
                    Back
                </ButtonAsLink>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="divide-y divide-gray-100 bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                        {{ status }}
                    </div>
                    <form @submit.prevent="submit">
                        <div class="mb-5">
                            <InputLabel for="company_name" value="Company Name" />

                            <TextInput
                                id="company_name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.company_name"
                                required
                                autofocus
                                autocomplete="company_name"
                            />

                            <InputError class="mt-2" :message="form.errors.company_name" />

                        </div>

                        <div class="mb-5">
                            <InputLabel for="name" value="Owner Name" />

                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required
                                autocomplete="name"
                            />

                            <InputError class="mt-2" :message="form.errors.name" />

                        </div>

                        <div class="mb-5">
                            <InputLabel for="username" value="Owner Username" />

                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.username"
                                required
                                autocomplete="username"
                            />

                            <InputError class="mt-2" :message="form.errors.username" />

                        </div>

                        <div class="mb-5">
                            <InputLabel for="email" value="Owner Email" />

                            <TextInput
                                id="email"
                                type="email"
                                class="mt-1 block w-full"
                                v-model="form.email"
                                required
                                autocomplete="email"
                            />

                            <InputError class="mt-2" :message="form.errors.email" />

                        </div>

                        <div class="mb-5">
                            <InputLabel for="logo" value="Company Logo" />

                            <!-- <TextInput
                                id="logo"
                                type="file"
                                class="mt-1 block w-full"
                                v-model="form.logo"
                                required
                            /> -->

                            <InputError class="mt-2" :message="form.errors.logo" />

                            <input type="file" @input="form.logo = $event.target.files[0]" />
                            <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                            {{ form.progress.percentage }}%
                            </progress>

                        </div>

                        <div class="flex items-center justify-between mt-4">
                            
                            <div>

                                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Create Company
                                </PrimaryButton>
                            </div>
                            <div>
                                <Transition
                                    enter-active-class="transition ease-in-out"
                                    enter-from-class="opacity-0"
                                    leave-active-class="transition ease-in-out"
                                    leave-to-class="opacity-0"
                                >
                                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                                </Transition>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
