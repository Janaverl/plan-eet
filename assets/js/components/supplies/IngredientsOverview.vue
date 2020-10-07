<template>
    <table
        class="w3-table w3-striped w3-bordered"
    >
        <thead>
            <th>rayon</th>
            <th>ingredient</th>
            <th>hoeveelheid</th>
        </thead>
        <tbody>
            <tr
                v-for="ingredient in ingredients"
                :key="ingredient.name"
            >
                <td>{{ingredient.rayon}}</td> 
                <td>{{ingredient.name}}</td> 
                <td>{{ingredient.quantity}} {{ingredient.unit}}</td> 
            </tr>
        </tbody>
    </table>
</template>

<script>

    import axios from 'axios';
    import {SuppliesEventBus} from '../../supplies';

    export default {
        name: "ingredients",
        data: function() {
            return{
                ingredients: null,
                rayon: null,
                daycount: null
            }
        },
        mounted() {
            this.fetchSupplies()
        },
        created() {
            const vm = this;

            SuppliesEventBus.$on('passRayons', (data) => {
                vm.rayon = data
                    .filter(obj => obj.isActive)
                    .map(obj => obj.name)
            })

            SuppliesEventBus.$on('passDays', (data) => {
                vm.daycount = data
                    .filter(obj => obj.isActive)
                    .map(obj => obj.campdaycount)
            })
        },
        watch: {
            rayon: function () {
                this.fetchSupplies()
            },
            daycount: function () {
                this.fetchSupplies()
            }
        },
        methods: {
            fetchSupplies() {
                axios
                    .get(`/api/camp/supplies/${window.currentCamp}`, {
                        params: {
                            rayons: this.rayon,
                            daycount: this.daycount
                        }
                    })
                    .then(response => {
                        this.ingredients = response.data;
                    })
                    .catch(error => {
                        console.log(error)
                    })
                    .finally(() => {
                    })
            }
        }
    }
</script>

<style scoped>
</style>