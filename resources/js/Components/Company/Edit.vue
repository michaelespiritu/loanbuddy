<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    company: {
        type: Object,
    }
});

const emit = defineEmits(['closeModal'])

const form = useForm({
    name: props.company.name,
});

const submit = () => {
    form.clearErrors()
    form.patch(route('company.update', props.company.id), {
        onSuccess: () => {
          emit('closeModal')
        }
    });
};

</script>

<template>
  <div class="p-6">
      <h2 class="text-lg font-medium text-gray-900">
          {{ company.name }}'s Information
      </h2>

      <div class="mt-6">
          <div>
              <InputLabel for="name" value="Company Name" />

              <TextInput
                  id="name"
                  type="text"
                  class="mt-1 block w-full"
                  v-model="form.name"
                  required
                  autofocus
                  autocomplete="name"
              />

              <InputError class="mt-2" :message="form.errors.name" />
          </div>
      </div>

      <div class="mt-6 flex justify-end items-center">
          <SecondaryButton @click="emit('closeModal')"> Cancel </SecondaryButton>

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
</template>