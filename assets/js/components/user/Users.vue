<template>
    <api-wrapper>
        <template>
            <table class="w3-table w3-striped w3-bordered" id="tableToSort">
                <thead>
                    <tr class="sortTitles">
                        <th class="sortable">naam</th>
                        <th class="sortable">rol</th>
                        <th class="sortable">aantal kampen aangemaakt</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="user in users"
                        :key="user.name"
                    >
                        <td>{{user.name}}</td> 
                        <td>{{user.roles}}</td> 
                        <td>{{user.campsCount}}</td> 
                    </tr>
                </tbody>
            </table>
        </template>
    </api-wrapper>
</template>

<script>

    import axios from 'axios';
    import ApiWrapper from '../Reusable/ApiWrapper';
    import {ApiEventBus} from '../../app';

    export default {
        name: "users",
        data: function() {
            return{
                users: null,
            }
        },
        mounted () {
            axios
                .get('/api/users')
                .then(response => {
                    this.users = response.data;
                })
                .catch(error => {
                    ApiEventBus.$emit('showError');
                })
                .finally(() => {
                    ApiEventBus.$emit('stopLoader');
                })
        },
        components: {
            ApiWrapper
        }

    }
</script>

<style scoped>
</style>