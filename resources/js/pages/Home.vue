<template>
    <div>
        <h1>Ultimi post del blog</h1>
        <nav class="bg-light my-3 d-flex justify-content-end">
            <button class="btn btn-outline-primary" @click="fetchPosts(pagination.current_page)">
                <i class="fas fa-redo me-2"></i>
                Ricarica dati
            </button>
        </nav>
        <div class="my-4">
            <input type="text" class="form-input" placeholder="Inserisci parola chiave." v-model="searchText" @keydown.enter="findSearchSubmit"/>
        </div>
        <div class="progress my-3" v-if="loading">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                Caricamento...
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <PostCard v-for="post of posts" :key="post.id" :post="post"></PostCard>
        </div>
        <nav aria-label="Page navigation example" class="d-flex justify-content-center my-5">
            <ul class="pagination m-0">
                <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
                    <a class="page-link" @click="fetchPosts(pagination.current_page - 1)">
                        Previous
                    </a>
                </li>
                <li class="page-item" :class="{ active: pagination.current_page === page }" v-for="page in pagination.last_page" :key="page">
                    <a class="page-link" @click="fetchPosts(page)">
                        {{ page }}
                    </a>
                </li>
                <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
                    <a class="page-link" @click="fetchPosts(pagination.current_page + 1)">
                        Next
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
import axios from "axios";
import PostCard from "../components/PostCard.vue";

export default {
    components: { PostCard },
    data() {
        return {
            posts: [],
            pagination: {},
            loading: true,
            searchText: ''
        }   
    },
    mounted() {
        this.fetchPosts();
    },
    methods: {
        async fetchPosts(page = 1, searchText = null) {
            if(page < 1) {
                page = 1;
            }

            if(page > this.pagination.last_page) {
                page = this.pagination.last_page;
            }

            this.loading = true;

            try {
                const resp = await axios.get('/api/posts', {
                    params: {
                        page,
                        filter: searchText
                    }
                });
                this.pagination = resp.data;
                this.posts = resp.data.data;
            } catch (er) {
                console.log(er);
            } finally {
                setTimeout(() => {
                    this.loading = false;
                }, 1000);
            }
        },
    
        findSearchSubmit() {
            this.fetchPosts(1, this.searchText);
        }
    }
};
</script>

<style scoped lang="scss">
</style>