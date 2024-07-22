<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import Pagination from '@/Components/Pagination.vue';
import { ref, watch } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import  debounce from "lodash/debounce"
import ButtonAsLink from '@/Components/ButtonAsLink.vue';

defineProps({
    companies: {
        type: Object,
    },
    status: {
        type: String,
    },
});

const search = ref();

watch(search, debounce(function(value) {
    router.get(route('company.index'), { search: value }, { preserveState: true, replace: true })
}, 500));

</script>

<template>
    <Head title="Company" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Companys</h2>
                <ButtonAsLink :href="route('company.create')" :active="route().current('company.create')" as="button">
                    Create Company
                </ButtonAsLink>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h3>Companies</h3>


                <TextInput
                    type="text"
                    class="mt-2 mb-5 block w-full"
                    required
                    autofocus
                    v-model="search"
                    placeholder="Search Company"
                />
                

                <ul role="list" class="divide-y divide-gray-100 bg-white overflow-hidden shadow-sm sm:rounded-lg px-5">
                    <li 
                        v-for="company in companies.data"
                        :key="company.id"
                        @click="router.get(route('company.show', company.id))"
                        class="flex justify-between gap-x-6 py-5">
                        <div class="flex min-w-0 gap-x-4">
                        <!-- <img class="h-12 w-12 flex-none rounded-full bg-gray-50" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt=""> -->
                        <div class="min-w-0 flex-auto">
                            <p class="text-sm font-semibold leading-6 text-gray-900">{{company.company_name}}</p>
                            <p class="text-sm leading-6 text-gray-900">Owner: {{company.user_name}}</p>
                        </div>
                        </div>
                        <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                        <ButtonAsLink 
                            :href="route('company.show', company.id)"
                        >
                            View
                        </ButtonAsLink>
                        </div>
                    </li>
                </ul>

                <Pagination :links="companies.meta.links" class="mt-5"/>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
