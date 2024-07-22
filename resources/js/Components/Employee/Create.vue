<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';

const props = defineProps({
    company: {
        type: Object,
    }
});

const emit = defineEmits(['closeModal'])

const form = useForm({
    name: '',
    username: '',
    role: '',
    email: '',
    path: usePage().url
});

const submit = () => {
    form.clearErrors()
    form.post(route('employee.store', props.company.id), {
        onSuccess: () => {
            form.reset()
            emit('closeModal', true)
        }
    });
};

</script>

<template>
  <div class="p-6">
    <h2 class="text-lg font-medium text-gray-900">
        Create Employee
    </h2>
    <hr class="my-3">
    <div class="mb-5">
        <InputLabel for="role" value="Role" />

        <TextInput
            id="name"
            type="text"
            class="mt-1 block w-full"
            v-model="form.role"
            required
            autocomplete="role"
        />

        <InputError class="mt-2" :message="form.errors.role" />

    </div>

    <div class="mb-5">
        <InputLabel for="name" value=" Name" />

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
        <InputLabel for="username" value="Username" />

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
        <InputLabel for="email" value="Email" />

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
              Save Changes
          </PrimaryButton>
      </div>
    </div>
    
  </div>
</template>