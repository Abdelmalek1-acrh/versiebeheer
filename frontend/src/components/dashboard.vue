<template>
    <div>
        <h2>Klantenoverzicht</h2>
        <ul>
            <li v-for="klant in klanten" :key="klant.id">
                <router-link :to="'/maintenance/' + klant.id">{{ klant.name }}</router-link>
            </li>
        </ul>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return { klanten: [] };
    },
    async created() {
        const res = await axios.get("http://localhost:5000/api/admin/customers");
        this.klanten = res.data;
    },
};
</script>
