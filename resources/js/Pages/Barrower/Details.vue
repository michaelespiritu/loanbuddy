<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CreateLoan from '@/Pages/Barrower/CreateLoan.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    barrower: {
        type: Object,
    },
});

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
    <Head :title=barrower.name />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ barrower.name }}</h2>
        </template>

        <div class="py-12" >
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">
                <h4>Barrower Personal Information</h4>
                  
                <ul role="list" class="divide-y divide-gray-100 bg-white overflow-hidden shadow-sm sm:rounded-lg px-5">
                    <li 
                        class="flex justify-between gap-x-6 py-5 items-center">
                        <div class="flex min-w-0 gap-x-4">
                          <!-- <img class="h-12 w-12 flex-none rounded-full bg-gray-50" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt=""> -->
                          <div class="min-w-0 flex-auto">
                              <p class="text-sm font-semibold leading-6 text-gray-900">{{barrower.name}}</p>
                              <p class="text-sm leading-6 text-gray-900">{{barrower.email}}</p>
                          </div>
                          </div>
                        <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                          <ButtonAsLink 
                              
                          >
                              View
                          </ButtonAsLink>
                        </div>
                    </li>
                </ul>

                <h4>Create Loan</h4>
                <CreateLoan :barrower="barrower"/>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
