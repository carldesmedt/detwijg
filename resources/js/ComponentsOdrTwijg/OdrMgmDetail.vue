<script setup>
import { ref, reactive, computed } from 'vue'
import ApplicationLogo from '@/ComponentsOdrTwijg/ApplicationLogo.vue';
import axios from 'axios';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    event: Object,
    shifts: Array,
    subscriptions: Array,
    param: Object
});
const subs = ref(props.subscriptions);
let search = ref('');
const query = ref(subs.value.filter((sub) => sub.reference));
const filtert = computed(() => {
    return query.value.filter((sub) => sub.reference.startsWith(search.value)|| sub.name.startsWith(search.value))
});
const myaxios = () => {
    
    axios.get('/axios').then(({data}) => console.log(data));
  
}
</script>

<template>
    <div>
        <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
            <ApplicationLogo class="block h-12 w-auto" />

            <h1 class="mt-8 text-2xl font-medium text-gray-900">
                Instellingen en details
            </h1>

            <div class="mt-6 text-gray-500 leading-relaxed">
                <div class="grid md:grid-cols-3 gap-32">
                    <div>
                        <div class="flex justify-between">
                            <span class="font-bold text-groen-twijg">Naam event:</span>
                            <span>{{ event.name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-bold text-groen-twijg">Datum<span v-if="event.date_end"> van</span>:</span>
                            <span>{{ event.date_start }}</span>
                        </div>
                        <div v-if="event.date_end" class="flex justify-between">
                            <span class="font-bold text-groen-twijg">Datum tot:</span>
                            <span>{{ event.date_end }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-bold text-groen-twijg">Online van:</span>
                            <span>{{ event.date_online }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-bold text-groen-twijg">Online tot:</span>
                            <span>{{ event.date_offline }}</span>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between">
                            <span class="font-bold text-groen-twijg">Inschrijven:</span>
                            <span v-if="shifts[0].subscription_required">verplicht</span><span v-else>nvt</span>
                        </div>
                        <div v-if="shifts[0].subscription_fee" class="flex justify-between">
                            <span class="font-bold text-groen-twijg">Bedrag:</span>
                            <span>{{ shifts[0].subscription_fee }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-bold text-groen-twijg">Maximum aantal:</span>
                            <span>{{ shifts[0].subscription_max }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-bold text-groen-twijg">Inschrijven van:</span>
                            <span>{{ shifts[0].subscription_start }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-bold text-groen-twijg">Inschrijven tot:</span>
                            <span>{{ shifts[0].subscription_end }}</span>
                        </div>
                        
                    </div>
                    
                </div>
                <div>
                    Aantal inschrijvingen : {{ subscriptions.length }}
                </div>
            </div>
        </div>

        <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1  gap-6 lg:gap-8 p-6 lg:p-8">
            <button type="submit" @click.prevent="myaxios">TEST</button>
            <div >
                <TextInput
                    id="query"
                    v-model="search"
                    type="text"
                    class="mt-1 block w-full"
                    
                />
            
                    <div class="grid grid-cols-7 font-bold text-groen-twijg text-center border-b mb-2">
                        <div>Team</div>
                        <div>Kapitein</div>
                        <div>Email</div>
                        <div>Telefoon</div>
                        <div>Bedrag</div>
                        <div>Referentie</div>
                        <div>Status</div>
                    </div>
                    <div >
                        <p v-for="detail in filtert" class="text-center text-xs grid grid-cols-7 gap-2">
                            <div v-if="param.subTeam">{{ detail.team }}</div>
                            <div v-if="param.subName">{{ detail.name }}</div>
                            <div v-if="param.subEmail">{{ detail.email }}</div>
                            <div v-if="param.subAddress">{{ detail.address }}</div>
                            <div v-if="param.subPhone">{{ detail.phone }}</div>
                            <div v-if="param.subContact">{{ detail.referenced_contact }}</div>
                            <div v-if="param.subClass">{{ detail.class }}</div>
                            <div>{{ detail.fee }}</div>
                            <div>{{ detail.reference }}</div>
                            <select :id="'status'+detail.id" v-model="detail.status" :value="detail.status" class="text-xs">
                                <option value="reserved">Gereserveerd</option><option value="paid">Betaald</option>
                            </select> 
                            
                        </p>
                    </div>   
            </div>
        </div>
    </div>
</template>
