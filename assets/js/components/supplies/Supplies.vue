<template>
    <div
        class="d-flex"
    >
        <dates-buttons
            style="flex-grow:1;flex-basis:0;"
        >
        </dates-buttons>
        <div 
            class="main"
            style="flex-grow:6;flex-basis:0;"
        >
            <rayons-buttons>
            </rayons-buttons>
            <ingredients-overview>
            </ingredients-overview>
        </div>
    </div>
</template>

<script>

    import axios from 'axios';
    import DatesButtons from './DatesButtons';
    import RayonsButtons from './RayonsButtons';
    import IngredientsOverview from './IngredientsOverview';

    export default {
        name: "supplies",
        components: {
            DatesButtons,
            RayonsButtons,
            IngredientsOverview
        }
    }

</script>

<style scoped>
</style>