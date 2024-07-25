<script setup>
import ButtonAsLink from '@/Components/ButtonAsLink.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import { computed, ref, watch, onMounted   } from 'vue';

const sched = ref([])

const props = defineProps({
    barrower: {
        type: Object,
    },
});

const form = useForm({
    loan_amount: '15000',
    interest: 7,
    duration: 3,
    frequency_of_payment: {value: 1, label: 'Per Month'},
    start_of_payment_date: new Date().toISOString().slice(0, 10),
    penalty: '0',
});

onMounted(() => {
    schedPayment()
})

const submit = () => {
    form.clearErrors()
    form.post(route('barrower.create.loan', props.barrower.id), {
        onSuccess: () => {
            form.reset()
        }
    });
};


watch(
  () => form.start_of_payment_date,
  (newValue, oldValue) => {
    sched.value = []
    schedPayment(newValue)
  },
  { deep: true }
)


const schedulePayment = computed(() => {
    // form.sched = []
    form.sched.push(form.start_of_payment_date)

    // const newSched = form.sched.slice(-1).pop()
    // console.log(newSched)
    // const duration = (form.frequency_of_payment.value == 1) ? form.duration : form.duration*form.frequency_of_payment.value
    for (let i = 0; i < duration-1; i++) {
        form.sched.push(schedPayment(newSched))
    }

    // return form.sched

    // const startDate = new Date(value)

    // form.sched.push(form.start_of_payment_date)

    // const newDate = (form.frequency_of_payment.value == 1) ? new Date(startDate.setMonth(startDate.getMonth() + 1)) : new Date(startDate.setMonth(startDate.getMonth() + 2))
    // //startDate.setDate(startDate.getDate() + toAdd)
    // // console.log(newDate.getMonth());

    // return newDate.toISOString().slice(0, 10)
})

const schedPayment = (value) => {

    sched.value.push(form.start_of_payment_date)

    const startDate = new Date(sched.value.slice(-1).pop())
    console.log(startDate)
    const duration = (form.frequency_of_payment.value == 1) ? form.duration : form.duration*form.frequency_of_payment.value

    for (let i = 0; i < duration-1; i++) {
        const dd = new Date(startDate.setMonth(startDate.getMonth() + 1))
        
        console.log( sched.value.push(dd.toISOString().slice(0, 10)) )
    }

    // const toAdd = (form.frequency_of_payment.value == 1) ? 1 : 2
    //startDate.setDate(startDate.getDate() + toAdd)
    // console.log(newDate.getMonth());

    // const newDate = new Date(startDate.setMonth(startDate.getMonth() + toAdd)) 
    // return newDate.toISOString().slice(0, 10)
    // return newDate
}
</script>

<template>
      <div class="">
          <!-- <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
              {{ status }}
          </div> -->
            <div class="grid grid-cols-2 gap-4">
                <form @submit.prevent="submit">
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

                            <select 
                                id="frequency_of_payment"
                                type="text"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                v-model="form.frequency_of_payment"
                                required
                                >
                                <option :value="{value: 2, label: 'Per Cut Off'}">Per Cut Off</option>
                                <option :value="{value: 1, label: 'Per Month'}">Per Month</option>
                            </select>

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
                </form>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <p>Principal: {{ form.loan_amount.toLocaleString() }}</p>
                    <p>Interest Rate: {{ form.interest }}%</p>
                    <p>Duration: {{ form.duration }} Months</p>

                    <hr class="my-4">

                    <p>Total Principal: {{ form.loan_amount.toLocaleString() }}</p>
                    <p>Total Interest Amount:  {{ (form.loan_amount*(form.interest/100).toLocaleString()).toLocaleString() }}/Month or {{ ((form.loan_amount*(form.interest/100))*form.duration).toLocaleString() }} for {{ form.duration }} Months</p>
                    <p>Total Loan: {{ (form.loan_amount+((form.loan_amount*(form.interest/100))*form.duration)).toLocaleString() }}</p>
                    <p>Term of Repayment: {{ form.frequency_of_payment.value == 2 ? '2x Per Month' : '1x Per Month' }}</p>
                    <p>Amount: {{ ((form.loan_amount+((form.loan_amount*(form.interest/100))*form.duration)) / (form.duration*form.frequency_of_payment.value)).toLocaleString() }} {{ form.frequency_of_payment.label }}</p>
                    <p>Schedule of Payment: </p>
                    <p
                        v-for="(schedule, index) in sched"
                        :key="index"
                    >{{ schedule  }}</p>
                    <hr>
                    <!-- <p
                        v-for="(schedule, index) in schedulePayment"
                        :key="index"
                    >{{ schedule }}</p> -->
                </div>
            </div>
      </div>
</template>
