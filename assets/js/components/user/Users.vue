<template>

    <section v-if="errored">
        <p>Er liep iets mis met het laden van de data. Probeer later opnieuw.</p>
    </section>

    <section v-else-if="loading">
        <p>De data is aan het laden.</p>
    </section>

    <section v-else>
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
    </section>

</template>

<script>

    import axios from 'axios';

    export default {
        name: "users",
        data: function() {
            return{
                users: null,
                loading: true,
                errored: false
            }
        },
        mounted () {
            axios
                .get('/api/users')
                .then(response => {
                    this.users = response.data;
                })
                .catch(error => {
                    console.log(error)
                    this.errored = true
                })
                .finally(() => this.loading = false)
        }

    }
</script>

<style scoped>
</style>