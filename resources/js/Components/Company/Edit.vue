<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, router } from '@inertiajs/vue3';

const props = defineProps({
    company: {
        type: Object,
    }
});

const emit = defineEmits(['closeCModal'])

const form = useForm({
    name: props.company.name,
    logo: null
});

const submit = () => {
    form.clearErrors()
    form.post(route('company.update', props.company.id), {
        onSuccess: () => {
          emit('closeModal', true)
        }
    });
};

</script>

<template>
  <div class="p-6">
    <h2 class="text-lg font-medium text-gray-900">
        {{ company.name }}'s Information
    </h2>
    <form @submit.prevent="submit">
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

        <div class="mt-6">
            <div>
				<InputLabel for="logo" value="Company Logo" />

				<input type="file" @input="form.logo = $event.target.files[0], console.log(form.logo)" />
				<!-- <progress v-if="form.progress" :value="form.progress.percentage" max="100">
				{{ form.progress.percentage }}%
				</progress> -->

				<InputError class="mt-2" :message="form.errors.logo" />
            </div>
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
                <SecondaryButton SecondaryButton 
                    v-if="! form.processing"
                    @click="emit('closeModal', false)">
                    Cancel
                </SecondaryButton>

                <PrimaryButton
                    class="ms-3"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Save Changes
                </PrimaryButton>
            </div>
        </div>
    </form>
  </div>
</template>