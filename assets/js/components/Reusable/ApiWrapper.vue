<template>

    <section v-if="errored">
        <p>Er liep iets mis met het laden van de data. Probeer later opnieuw.</p>
    </section>

    <section v-else-if="loading">
        <p>De data is aan het laden.</p>
    </section>

    <section v-else>
        <slot></slot>
    </section>

</template>

<script>
    import {ApiEventBus} from '../../api';

    export default {
        name: "apiWrapper",
        data: function() {
            return{
                loading: true,
                errored: false
            }
        },
        created() {
            const vm = this;

            ApiEventBus.$on('showError', () => {
                vm.errored = true;
            })

            ApiEventBus.$on('stopLoader', () => {
                vm.loading = false;
            })
        }

    }
</script>

<style scoped>
</style>