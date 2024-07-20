<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import CompanyEdit from '@/Components/Company/Edit.vue';
import { Link } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const confirmEditCompanyName = ref(false)

defineProps({
    company: {
        type: Object,
    },
    employees: {
        type: Object,
    },
});

const closeModal = () => {
    confirmEditCompanyName.value = false;
};

</script>

<template>
    <Head title="Company" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ company.name }} 
                    <small 
                        class="text-xs"
                        @click="confirmEditCompanyName = true"
                    >
                        Edit
                    </small>
                </h2>
                <Link :href="route('company.index')" :active="route().current('company.index')" as="button">
                    Back
                </Link>
            </div>
        </template>

        <Modal :show="confirmEditCompanyName" @close="closeModal">
            <CompanyEdit 
                :company="company"
                @close-modal="closeModal"/>
        </Modal>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h2 class="text-2xl mb-4">Employees</h2>
                <ul role="list" class="divide-y divide-gray-100 bg-white overflow-hidden shadow-sm sm:rounded-lg px-5">
                    <li 
                        v-for="employee in employees"
                        :key="employee.id"
                        class="flex justify-between gap-x-6 py-5">
                        <div class="flex min-w-0 gap-x-4">
                        <img class="h-12 w-12 flex-none rounded-full bg-gray-50" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                        <div class="min-w-0 flex-auto">
                            <p class="text-sm font-semibold leading-6 text-gray-900">{{employee.name}}</p>
                            <p class="text-sm leading-6 text-gray-900">Role: {{employee.role}}</p>
                        </div>
                        </div>
                        <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                        <p class="mt-1 text-xs leading-5 text-gray-500">Last seen <time datetime="2023-01-23T13:23Z">3h ago</time></p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
