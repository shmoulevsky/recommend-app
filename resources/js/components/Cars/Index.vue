<template>
    <div>
        <Pagination
            :current=parseInt(currentPage)
            :lastPage=parseInt(lastPage)
            :links=links
            @navClick="navClick"
        ></Pagination>
        <div>
            <h1>Cars list</h1>
            <CarTable  :cars="cars" @tdClick="getSimilar"></CarTable>
        </div>
        <div v-if="similar">
            <h1>Similar cars</h1>
            <CarTable  :cars="similar" @tdClick=""></CarTable>
        </div>

    </div>
</template>

<script setup lang="ts">
import axios from 'axios';
import Pagination from "../Common/Pagination.vue";
import { ref } from 'vue'
import CarTable from "./CarTable.vue";

let currentPage = ref("1")
let lastPage = ref()
let cars = ref([])
let similar = ref([])
let links = ref([])

getList(currentPage.value)

function getList(page){
    axios.get('/api/v1/cars?page='+page)
        .then(response => {
            cars.value = response.data.data;
            links.value = response.data.meta.links;
            lastPage.value = response.data.meta?.last_page;
        })
        .catch(error => {
            console.error('Error fetching cars:', error);
        });
}

function navClick(page:string){
    currentPage.value = page;
    getList(currentPage.value)
}

function getSimilar(car:any){
    axios.get('/api/v1/cars/similar/'+car.id)
        .then(response => {
            similar.value = response.data.data;

        })
        .catch(error => {
            console.error('Error fetching similar cars:', error);
        });
}

</script>

<style scoped>
h1{
    font-size: 42px;
    margin-bottom: 20px;
}
</style>
