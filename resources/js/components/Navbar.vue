<template>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/">Laravel Boolpress</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-bs-controls="navbarSupportedContent" aria-bs-expanded="false">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item" v-for="route in routes" :key="route.path">
                        <router-link class="nav-link" :to="!route.path ? '/' : route.path">
                            {{ route.meta.linkName }}
                        </router-link>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/login" v-if="!user">
                            Login
                        </a>
                        <a class="nav-link" href="/admin" v-else>
                            {{ user.name }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import Axios from 'axios';

export default {
    data() {
        return {
            routes: [],
            user: null
        };
    },
    mounted() {
        this.routes = this.$router.getRoutes().filter((route) => !!route.meta.linkName);

        this.fetchUser();
    },
    methods: {
        fetchUser() {
            Axios.get('/api/user').then((resp) => {
                this.user = resp.data;

                localStorage.setItem('user', JSON.stringify(resp.data));
                window.dispatchEvent(new CustomEvent('storedUserChanged'));
            }).catch((er) => {
                console.error('Utente non loggato');

                localStorage.removeItem('user');
                window.dispatchEvent(new CustomEvent('storedUserChanged'));
            });
        }
    }
};
</script>

<style scoped lang="scss">
</style>