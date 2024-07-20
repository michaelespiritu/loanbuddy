<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
});

const submit = () => {
    axios.post(route('barrower.create'), form)
    .then(res => {
      console.log(res.data)
    })
};

</script>

<template>
    <Head title="Create Barrower" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Barrower</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

              <form @submit.prevent="submit">
                  <div>
                      <InputLabel for="email" value="Email" />

                      <TextInput
                          id="email"
                          type="email"
                          class="mt-1 block w-full"
                          v-model="name"
                          required
                          autofocus
                          autocomplete="username"
                      />

                  </div>

                  <div class="flex items-center justify-between mt-4">
                     
                      <div>

                          <PrimaryButton>
                              Create Barrower
                          </PrimaryButton>
                      </div>
                  </div>
              </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
