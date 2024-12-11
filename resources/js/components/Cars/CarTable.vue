<template>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Year</th>
            <th>Engine hp</th>
            <th>Transmission type</th>
            <th>Driven wheel</th>
            <th>Market category</th>
            <th>Vehicle size</th>
            <th>Msrp</th>
            <td>Dist</td>
            <th>Details</th>
        </tr>
        </thead>
        <tbody>
        <tr :class="car.active === true ? 'active':''" v-for="car in cars" :key="car.id" @click="tdClick(car)">
            <td>{{ car.id }}</td>
            <td>{{ car.name }}</td>
            <td>{{ car.year }}</td>
            <td>{{ car.engine_hp }}</td>
            <td>{{ car.transmission_type }}</td>
            <td>{{ car.driven_wheel }}</td>
            <td>{{ car.market_category }}</td>
            <td>{{ car.vehicle_size }}</td>
            <td>{{ car.msrp }}</td>
            <td>{{ car.distance }}</td>
            <td>
                <router-link :to="`/cars/${car.id}`" class="btn btn-primary btn-sm">View Details</router-link>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script setup lang="ts">
    const props = defineProps<{ cars: Array<any>}>()
    const emit = defineEmits(['tdClick'])

    function tdClick(item:any){
        props.cars.map((car) => {
            car.active = false
        })
        item.active = true
        emit('tdClick', item);
    }
</script>

<style lang="scss" scss scoped>
@import "./../../../css/variables.scss";

table{
    width: 100%;
    border-collapse: collapse;
}

tr.active td{
    background-color: $primaryColor;
    color: #ffffff;
}

tr.active td a{
    color: #ffffff;
}

td, th{
    border: 1px solid #ccc;
    padding: 2px 5px;
    text-align: center;
    cursor: pointer;
}
</style>
