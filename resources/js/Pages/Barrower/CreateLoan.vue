<script setup>
import ButtonAsLink from '@/Components/ButtonAsLink.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    barrower: {
        type: Object,
    },
});


const form = useForm({
    loan_amount: '',
    interest: '',
    duration: '',
    frequency_of_payment: '',
    start_of_payment_date: '',
    penalty: '0',
});

const submit = () => {
    form.clearErrors()
    form.post(route('barrower.create.loan', props.barrower.id), {
        onSuccess: () => {
            form.reset()
        }
    });
};


</script>

<template>
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
          <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
              {{ status }}
          </div>
          <div class="mb-5">
              <InputLabel for="loan_amount" value="Loan Amount" />

              <TextInput
                  id="loan_amount"
                  type="number"
                  class="mt-1 block w-full"
                  v-model="form.loan_amount"
                  required
                  autofocus
                  autocomplete="loan_amount"
              />

              <InputError class="mt-2" :message="form.errors.loan_amount" />

          </div>

          <div class="mb-5">
              <InputLabel for="interest" value="Interest Rate" />

              <TextInput
                  id="interest"
                  type="text"
                  class="mt-1 block w-full"
                  v-model="form.interest"
                  required
                  autocomplete="interest"
              />

              <InputError class="mt-2" :message="form.errors.interest" />

          </div>

          <div class="mb-5">
              <InputLabel for="duration" value="Duration (Months to Repay)" />

              <TextInput
                  id="duration"
                  type="text"
                  class="mt-1 block w-full"
                  v-model="form.duration"
                  required
                  autocomplete="duration"
              />

              <InputError class="mt-2" :message="form.errors.duration" />

          </div>

          <div class="mb-5">
              <InputLabel for="frequency_of_payment" value="Frequency of Payment per Month" />

              <TextInput
                  id="frequency_of_payment"
                  type="text"
                  class="mt-1 block w-full"
                  v-model="form.frequency_of_payment"
                  required
                  autocomplete="frequency_of_payment"
              />

              <InputError class="mt-2" :message="form.errors.frequency_of_payment" />

          </div>

          <div class="mb-5">
              <InputLabel for="start_of_payment_date" value="Start of Payment" />

              <TextInput
                  id="start_of_payment_date"
                  type="date"
                  class="mt-1 block w-full"
                  v-model="form.start_of_payment_date"
                  required
                  autocomplete="start_of_payment_date"
              />

              <InputError class="mt-2" :message="form.errors.start_of_payment_date" />

          </div>

          <div class="flex items-center justify-between mt-4">
              
              <div>

                  <PrimaryButton 
                    @click="submit"
                    :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                  >
                      Create Loan
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
      </div>
</template>
