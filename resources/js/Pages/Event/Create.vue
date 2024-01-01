<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Checkbox from '@/Components/Checkbox.vue';

const props = defineProps([
    'ro_names',
]);
const toggle = ref({
    multidate: false,
    multishift: false,
    location: false,
    subscription: false,
    order: false,
});
const temp = ref({
    time_start: null,
    time_end: null,
    sub_start: null,
    sub_end: null,
    sub_fee: null,
    sub_max: null,
    location: null,
    sub_param: {
        subName: true,
        subEmail: true,
        subPhone: false,
        subAddress: false,
        subContact: false,
        subClass: false,
        subTeam: false
    },
});
const shifts = ref([

]);
const form = useForm({
    _method: 'POST',
    name: null,
    slug: null,
    description: null,
    date_start: null,
    date_end: null,
    date_online: Date.now(),
    date_offline: null,
    shifts: null,
    
    
});
const populate = (shift) => {
    shift.subscription_required = toggle.value.subscription;
    shift.subscription_fee = temp.value.sub_fee;
    shift.subscription_start = temp.value.sub_start; 
    shift.subscription_end = temp.value.sub_end;
    shift.subscription_param = temp.value.sub_param;
    shift.location = temp.value.location;

}
const createEvent = () => {
    if(shifts.value.length == 0){
        shifts.value.push({
            date: form.date_start,
            shift_start: temp.value.time_start,
            shift_end: temp.value.time_end,
            subscription_required: toggle.value.subscription,
            subscription_max: temp.value.sub_max, 
            subscription_fee: temp.value.sub_fee, 
            subscription_start: temp.value.sub_start, 
            subscription_end: temp.value.sub_end,
            subscription_param: temp.value.sub_param,
            location: temp.value.location,
        })
    }
    shifts.value.forEach(populate)
    
    form.shifts = shifts;
    form.description = form.description.replace(/(?:\r\n|\r|\n)/g, "<br>");
    form.post(route('event.store'), {
        preserveScroll: true,
    });
};

const uniqueName = (value, type) => {
    if(props.ro_names.includes(value)){
        alert('Er bestaat reeds een evenement met dezelfde naam. Evenementnamen moeten uniek zijn');
        form.name = null;
        form.slug = null;
    }
    else{
        form.slug = form.name.toLowerCase().replace(/ /g,"-");
    }
};
const shiftMod = (action, index) => {
    switch (action){
        case 'add':
            shifts.value.push({
                date: null, 
                shift_start: null, 
                shift_end: null, 
                subscription_required: toggle.value.subscription,
                subscription_max: null, 
                subscription_fee: null, 
                subscription_start: null, 
                subscription_end: null, 
                subscription_param: null,
                location: temp.value.location,
            });
            break;
        case 'del':
            shifts.value.splice(index, 1);
            if(shifts.value.length == 0){
                toggle.value.multishift = false;
            }
            break;
    }
    
    
}
const location = () => {
    if(!toggle.value.location){
        temp.value.location = null;
    }
};

const toggled = (toggled) => {
    switch (toggled) {
        case 'multidate':
            if(!toggle.value.multidate){
                form.date_end = null;
            }
            else{
                temp.value.time_start = null;
                temp.value.time_end = null;
            }
            break;
        case 'multishift':
            if(toggle.value.multishift){
                shifts.value = [];
                shiftMod('add');
            }
            else{
                shifts.value = [];
            }
            break;
        case 'location':
            if(!toggle.value.location){
                temp.value.location = null;
            }
            break;
        case 'subscription':
            if (!toggle.value.subscription){
                temp.value.sub_start= null;
                temp.value.sub_end= null;
                temp.value.sub_fee= null;
            }
    }
}

</script>
<template>
    <AppLayout title="Evenement aanmaken">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Nieuw Evenement
            </h2>
        </template>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <FormSection @submitted="createEvent">
                <template #title>
                    Nieuw Evenement aanmaken
                </template>
                <template #description>
                    <p class="pt-2"><span class="font-bold">Type </span><span class="text-xs">required</span><br>Kies voor elk event een type. Afhanklijk van het gekozen type wijzigt het formulier met de nodige invoervelden.</p>
                </template>
                <template #form>
                    <div class="col-span-6 sm:col-span-4 font-bold text-lg">Algemeen</div>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="name" value="Naam*" class="underline"/>
                        <TextInput
                            id="name"
                            v-model="form.name"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            @focusout = "uniqueName(form.name)"
                        />
                        <InputError :message="form.errors.name" class="mt-2" />

                        <div class="text-sm">URL: /{{ form.slug }}</div>

                        <InputLabel for="description" value="Omschrijving*" class="underline mt-4"/>
                        <textarea
                            id="description"
                            v-model="form.description"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                            required
                        />
                        <InputError :message="form.errors.description" class="mt-2" />

                        <div  v-if="toggle.multidate" class="grid grid-cols-2 gap-4">
                            <div>
                                <InputLabel for="startdate" value="Startdatum*" class="underline mt-4"/>
                                <TextInput
                                    id="startdate"
                                    v-model="form.date_start"
                                    type="date"
                                    class="mt-1 block w-full"
                                    required
                                />
                                <InputError :message="form.errors.date_start" class="mt-2" />
                            </div>
                            <div>
                                <InputLabel for="enddate" value="Einddatum*" class="underline mt-4"/>
                                <TextInput
                                    id="enddate"
                                    v-model="form.date_end"
                                    type="date"
                                    class="mt-1 block w-full"
                                    :min="form.date_start"
                                    required
                                />
                                <InputError :message="form.errors.date_end" class="mt-2" />
                            </div>
                        </div>
                        <div v-else class="grid grid-cols-2 gap-4">
                            <div>
                                <InputLabel for="startdate" value="Datum*" class="underline mt-4"/>
                                <TextInput
                                    id="startdate"
                                    v-model="form.date_start"
                                    type="date"
                                    class="mt-1 block w-full"
                                    required
                                />
                                <InputError :message="form.errors.date_start" class="mt-2" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 mt-2">
                            <span class="text-xs">Het evenement bestrijkt meerdere dagen</span>
                            <Checkbox id="multidate" v-model="toggle.multidate" @change="toggled('multidate')"/>
                        </div>
                        <div v-if="!toggle.multidate">
                            <InputLabel value="Tijdstip" class="underline mt-4"/>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <InputLabel for="starthour" value="Van*" class="mt-2"/>
                                    <TextInput
                                        id="starthour"
                                        v-model="temp.time_start"
                                        type="time"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                </div>
                                <div>
                                    <InputLabel for="endhour" value="Tot*" class="mt-2"/>
                                    <TextInput
                                        id="endhour"
                                        v-model="temp.time_end"
                                        type="time"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                </div>
                            </div>
                        </div>
                        <!--<div class="grid grid-cols-2 mt-4">
                            <span >Het evenement is opgedeeld in meerdere shiften</span>
                            <Checkbox id="multishift" v-model="toggle.multishift" class="mt-2" @change="toggled('multishift')"/>
                        </div>-->
                        <div v-if="toggle.multishift">
                            <div v-for="(shift, index) in shifts" class="grid grid-cols-2 gap-4 border-2 rounded-lg p-4 my-4">
                                <div class="font-bold text-md ">Shift {{ index+1 }}</div>
                                <div class="col-span-2">
                                    <InputLabel :for="'shiftdate'.index" value="Datum"/>
                                    <TextInput
                                        :id="'shiftdate'.index"
                                        v-model="shift.date"
                                        type="date"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                </div>
                                <div>
                                    <InputLabel :for="'shift_start'.index" value="Van" />
                                    <TextInput
                                        :id="'shift_start'.index"
                                        v-model="shift.shift_start"
                                        type="time"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                </div>
                                <div>
                                    <InputLabel :for="'shift_end'.index" value="Tot" />
                                    <TextInput
                                        :id="'shift_end'.index"
                                        v-model="shift.shift_end"
                                        type="time"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                </div>
                                
                                <div class="text-center   border-4 bg-red-200 cursor-pointer rounded-full" @click.prevent="shiftMod('del',index)">Shift verwijderen</div> 
                            </div>
                            <div class="text-center mt-4 border-4 w-1/3 bg-green-200 cursor-pointer rounded-full" @click.prevent="shiftMod('add')">Shift toevoegen</div>
                        </div>
                        <div class="grid grid-cols-2 mt-4">
                            <span >Het evenement gaat door op een fysieke locatie</span>
                            <Checkbox id="locationtoggle" v-model="toggle.location" class="mt-2" @change="toggled('location')"/>
                        </div>
                        <div v-if="toggle.location" class="mt-4">
                            <InputLabel for="location" value="Locatie*" class="underline"/>
                            <TextInput
                                id="location"
                                v-model="temp.location"
                                type="text"
                                class="mt-1 block w-full"
                                required
                                @focusout = "toggled('location')"
                            />
                        </div>
                    </div>
                    <div class="col-span-6 sm:col-span-4 font-bold text-lg mt-6 border-t-4">Weergave</div>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="name" value="Evenement online weergeven" class="underline"/>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <InputLabel for="name" value="van" />
                                <TextInput
                                        id="starthour"
                                        v-model="form.date_online"
                                        type="date"
                                        class="mt-1 block w-full"
                                        required
                                    />
                            </div>
                            <div>
                                <InputLabel for="name" value="tot" />
                                <TextInput
                                        id="starthour"
                                        v-model="form.date_offline"
                                        type="date"
                                        class="mt-1 block w-full"
                                        :min="form.date_online.getDay"
                                        required
                                    />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 mt-4">
                            <span >Inschrijvingsformulier weergeven</span>
                            <Checkbox id="subscriptiontoggle" v-model="toggle.subscription" class="mt-2" @change="toggled('subscription')"/>
                        </div>
                        <div class="grid grid-cols-2 mt-4">
                            <span class="text-gray-300">Bestelformulier weergeven</span>
                            <Checkbox id="ordertoggle"  class="mt-2" disabled/>
                        </div>
                    </div>
                    <div v-if="toggle.subscription" class="col-span-6 sm:col-span-4 font-bold text-lg mt-6 border-t-4">Inschrijvingen</div>
                    <div v-if="toggle.subscription" class="col-span-6 sm:col-span-4">
                        <InputLabel value="Inschijvingsperiode" class="underline"/>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <InputLabel value="van" for="startsub" />
                                <TextInput
                                    id="startsub"
                                        v-model="temp.sub_start"
                                        type="date"
                                        class="mt-1 block w-full"
                                        required
                                    />
                            </div>
                            <div>
                                <InputLabel value="tot" for="endsub" />
                                <TextInput
                                    id="endsub"
                                        v-model="temp.sub_end"
                                        type="date"
                                        class="mt-1 block w-full"
                                        required
                                        :max="form.date_start"
                                    />
                            </div>
                            <div>
                                <InputLabel value="Bedrag" for="subFee" class="mt-4"/>
                                <TextInput
                                    id="subFee"
                                    v-model="temp.sub_fee"
                                    type="number"
                                    class="mt-1 block w-full"
                                    
                                />
                            </div>
                            
                        </div>
                        <InputLabel value="Benodigde gegevens inschrijver" for="subName" class="underline mt-4"/>
                        <div class="mt-4 grid grid-cols-3">
                            <div class="grid grid-cols-2">
                                <InputLabel value="Naam" for="subName"/>
                                <Checkbox id="subName"  v-model="temp.sub_param.subName" disabled checked/>
                            </div>
                            <div class="grid grid-cols-2">
                                <InputLabel value="Email" for="subEmail"/>
                                <Checkbox id="subEmail"  v-model="temp.sub_param.subEmail" disabled checked/>
                            </div>
                            <div class="grid grid-cols-2">
                                <InputLabel value="Adres" for="subAddress"/>
                                <Checkbox id="subAddress"  v-model="temp.sub_param.subAddress" />
                            </div>
                            <div class="grid grid-cols-2">
                                <InputLabel value="Telefoon" for="subPhone"/>
                                <Checkbox id="subPhone"  v-model="temp.sub_param.subPhone" />
                            </div>
                            <div class="grid grid-cols-2">
                                <InputLabel value="Contact in school" for="subContact"/>
                                <Checkbox id="subContact"  v-model="temp.sub_param.subContact" />
                            </div>
                            <div class="grid grid-cols-2">
                                <InputLabel value="Klas" for="subClass"/>
                                <Checkbox id="subClass"  v-model="temp.sub_param.subClass" />
                            </div>
                            <div class="grid grid-cols-2">
                                <InputLabel value="Ploegnaam" for="subTeam"/>
                                <Checkbox id="subTeam"  v-model="temp.sub_param.subTeam" />
                            </div>
                        </div>
                        <div v-if="!toggle.multishift" class="mt-4 grid grid-cols-2 gap-4">
                            <InputLabel value="Maximum aantal inschrijvingen" for="subMax" class="mt-4"/>
                            <TextInput
                                id="subMax"
                                v-model="temp.sub_max"
                                type="number"
                                class="mt-1 block w-full"
                                required
                            />
                        </div>
                        <div v-else class="mt-4">
                            <div v-for="(shift, index) in shifts" class="grid grid-cols-2 gap-4">
                                <InputLabel :for="'subscription_max'.index" :value="'Max deelnemers shift '+(index+1)" />
                                <TextInput
                                    :id="'subscription_max'.index"
                                    v-model="shift.subscription_max"
                                    type="number"
                                    class="mt-1 block w-full"
                                    required
                                />
                            </div>
                            
                        </div>
                        
                    </div>
                </template>
                <template #actions>
                    <ActionMessage :on="form.recentlySuccessful" class="me-3">
                        Saved.
                    </ActionMessage>

                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Save
                    </PrimaryButton>
                </template>
            </FormSection>
        </div>
    </AppLayout>
</template>