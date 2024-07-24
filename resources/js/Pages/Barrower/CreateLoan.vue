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
    interest: 7,
    duration: 3,
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
      <div class="">
          <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
              {{ status }}
          </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <div class="mb-5 ">
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
                                v-if="!form.processing"
                                @click="submit"
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
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <p>Principal: {{ form.loan_amount.toLocaleString() }}</p>
                    <p>Interest Rate: {{ form.interest }}%</p>
                    <p>Duration: {{ form.duration }} Months</p>

                    <hr class="my-4">

                    <p>Total Principal: {{ form.loan_amount.toLocaleString() }}</p>
                    <p>Total Interest Amount:  {{ (form.loan_amount*(form.interest/100).toLocaleString()).toLocaleString() }}/Month or {{ ((form.loan_amount*(form.interest/100))*form.duration).toLocaleString() }} for {{ form.duration }} Months</p>
                    <p>Total Loan: {{ (form.loan_amount+((form.loan_amount*(form.interest/100))*form.duration)).toLocaleString() }}</p>
                    <p>Term of Repayment: {{ form.frequency_of_payment }}</p>
                    <p>Amount: {{ ((form.loan_amount+((form.loan_amount*(form.interest/100))*form.duration)) / (form.duration*2)).toLocaleString() }} {{ form.frequency_of_payment }}</p>
                </div>
            </div>
      </div>
</template>
