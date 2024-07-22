<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import ButtonAsLink from '@/Components/ButtonAsLink.vue';
import CompanyEdit from '@/Components/Company/Edit.vue';
import EmployeeEdit from '@/Components/Employee/Edit.vue';
import {  ref } from 'vue';

const confirmEditCompanyName = ref(false)
const confirmEditEmployeeDetails = ref(false)
const editEmployeeEditDetails = ref(null)

defineProps({
    company: {
        type: Object,
    },
    employees: {
        type: Object,
    },
    status: {
        type: String,
    },
});

const closeCompanyEditModal = (delay = false) => {
    let timer = (delay) ? 800 : 0;
    
    setTimeout(()=>{
        confirmEditCompanyName.value = false;
    }, timer)
};

const closeEmployeeEditModal = (delay = false) => {
    let timer = (delay) ? 800 : 0;
    setTimeout(()=>{
        confirmEditEmployeeDetails.value = false;
        editEmployeeEditDetails.value = '';
    }, timer)
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
                        class="text-xs cursor-pointer text-rose-700"
                        @click="confirmEditCompanyName = true"
                    >
                        Edit
                    </small>
                </h2>
                <ButtonAsLink :href="route('company.index')" :active="route().current('company.index')" as="button">
                    Back
                </ButtonAsLink>
            </div>
        </template>

        <Modal :show="confirmEditCompanyName" @close="closeCompanyEditModal">
            <CompanyEdit 
                :company="company"
                @close-modal="closeCompanyEditModal"/>
        </Modal>

        <Modal :show="confirmEditEmployeeDetails" @close="closeEmployeeEditModal">
            <EmployeeEdit 
                :employee="editEmployeeEditDetails"
                :company="company"
                @close-modal="closeEmployeeEditModal"/>
        </Modal>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl">Employees</h2>
                    <ButtonAsLink :href="route('employee.create', company.id)" :active="route().current('employee.create', company.id)" as="button">
                        Add
                    </ButtonAsLink>
                </div>
                <ul role="list" class="divide-y divide-gray-100 bg-white overflow-hidden shadow-sm sm:rounded-lg px-5">
                    <li 
                        v-for="employee in employees"
                        :key="employee.id"
                        class="flex justify-between items-center gap-x-6 py-5">
                        <div class="flex min-w-0 gap-x-4">
                        <!-- <img class="h-12 w-12 flex-none rounded-full bg-gray-50" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt=""> -->
                        <div class="min-w-0 flex-auto">
                            <p class="text-sm font-semibold leading-6 text-gray-900">{{employee.name}}</p>
                            <p class="text-sm leading-6 text-gray-900">Role: {{employee.role}}</p>
                        </div>
                        </div>
                        <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                        <SecondaryButton 
                            @click="confirmEditEmployeeDetails = true, editEmployeeEditDetails=employee"
                        >
                            Edit
                        </SecondaryButton>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
