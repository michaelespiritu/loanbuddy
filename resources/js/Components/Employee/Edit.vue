<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    employee: {
        type: Object,
    },
    company: {
        type: Object,
    }
});

const emit = defineEmits(['closeModal'])

const form = useForm({
    role: props.employee.role,
    name: props.employee.name,
    username: props.employee.username,
    email: props.employee.email,
});

const submit = () => {
    form.clearErrors()
    form.patch(route('employee.update', {'company': props.company.id, 'employee': props.employee.id}), {
        onSuccess: () => {
          emit('closeModal')
        }
    });
};

</script>

<template>
  <div class="p-6">
    <h2 class="text-lg font-medium text-gray-900">
        Edit {{ employee.name }}'s Information
    </h2>
    
    <p><small>Employee of {{ company.name }}</small></p>
      
    <div class="mt-6">
        <div>
            <InputLabel for="role" value="Employee Role" />

            <TextInput
                id="role"
                type="text"
                class="mt-1 block w-full"
                v-model="form.role"
                required
                autofocus
                autocomplete="role"
            />

            <InputError class="mt-2" :message="form.errors.role" />
        </div>
    </div>
    
    <div class="mt-6">
        <div>
            <InputLabel for="name" value="Employee Name" />

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
            <InputLabel for="username" value="Employee Username" />

            <TextInput
                id="username"
                type="text"
                class="mt-1 block w-full"
                v-model="form.username"
                required
                autofocus
                autocomplete="username"
            />

            <InputError class="mt-2" :message="form.errors.username" />
        </div>
    </div>

    <div class="mt-6">
        <div>
            <InputLabel for="email" value="Employee Email" />

            <TextInput
                id="email"
                type="text"
                class="mt-1 block w-full"
                v-model="form.email"
                required
                autofocus
                autocomplete="email"
            />

            <InputError class="mt-2" :message="form.errors.email" />
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
  </div>
</template>