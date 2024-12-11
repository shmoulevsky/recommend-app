<template>
    <div class="content">
        <div>
            <h1>Car {{car.name}}</h1>
            <ul class="features">
                <li><span class="title">Year:</span><span class="value">{{car.year}}</span></li>
                <li><span class="title">Transmission type:</span>{{car.transmission_type}}<span class="value"></span></li>
                <li><span class="title">Driven wheel:</span><span class="value">{{car.driven_wheel}}</span></li>
                <li><span class="title">Market category:</span><span class="value">{{car.market_category}}</span></li>
                <li><span class="title">Vehicle size:</span><span class="value">{{car.vehicle_size}}</span></li>
                <li><span class="title">Vehicle style:</span><span class="value">{{car.vehicle_style}}</span></li>
                <li><span class="title">Engine hp:</span><span class="value">{{car.engine_hp}}</span></li>
                <li><span class="title">Engine cylinders:</span><span class="value">{{car.engine_cylinders}}</span></li>
                <li><span class="title">Number doors:</span><span class="value">{{car.number_doors}}</span></li>
                <li><span class="title">Highway mpg:</span><span class="value">{{car.highway_mpg}}</span></li>
                <li><span class="title">City mpg:</span><span class="value">{{car.city_mpg}}</span></li>
                <li><span class="title">Msrp:</span><span class="value">{{car.msrp}}</span></li>
            </ul>

        </div>
        <div v-if="similar">
            <h1>Similar cars</h1>
            <CarTable  :cars="similar" @tdClick=""></CarTable>
        </div>
        <div class="btn-wrap">
            <router-link class="btn" to="/cars">To list</router-link>
        </div>
    </div>
</template>

<script setup lang="ts">
import axios from 'axios';
import { ref } from 'vue'
import {useRoute} from "vue-router";
import CarTable from "./CarTable.vue";

let car = ref({})
let similar = ref([])
const route = useRoute()

getDetail(route.params.id)
getSimilar(route.params.id)

function getDetail(id){
    axios.get('/api/v1/cars/'+id)
        .then(response => {
            car.value = response.data.data;

        })
        .catch(error => {
            console.error('Error fetching cars:', error);
        });
}

function getSimilar(id:any){
    axios.get('/api/v1/cars/similar/' + id)
        .then(response => {
            similar.value = response.data.data;

        })
        .catch(error => {
            console.error('Error fetching similar cars:', error);
        });
}


</script>

<style scoped lang="scss">
@import "./../../../css/variables.scss";

h1{
    font-size: 42px;
    margin-bottom: 20px;
}

.features{
    list-style-type: none;
    max-width: 450px;
}

.content{
    padding: 20px;
}

.features li{
    margin-bottom: 3px;
    border-bottom: 1px solid #ccc;
    display: block;
    padding: 3px 5px 3px 10px;
}

.title{
    width: 200px;
    display: inline-block;
    font-weight: bold;
    vertical-align: top;
}

.value{
    width: 200px;
    display: inline-block;
}

.btn-wrap{
    margin-top: 30px;
}

.btn{
    background-color: $primaryColor;
    border-radius: 3px;
    border: 1px solid $primaryColor;
    color: #fff;
    text-decoration: none;
    padding: 10px 20px;
    display: inline-block;
}

</style>
