<template>
    <div class="col">
        <div class="card">
            <img src="" class="card-img-top" alt="..." />
            <div class="card-body">
                <h5 class="card-title">{{ post.title }}</h5>
                <p class="card-text" v-html="post.content"></p>
                <em>
                    Autore: {{ post.user.name }} -
                    Data creazione: {{ formatDate(post.created_at) }}
                </em>
                <br/>
                <div v-if="post.category">
                    <span>
                        Categoria: {{ post.category.name }}
                    </span>
                </div>
                <div v-if="post.tags">
                    <span v-for="tag in post.tags" :key="tag.id">
                        Tag: {{ tag.name }}
                    </span>
                </div>
            </div>
            <div class="card-footer">
                <router-link :to="{ name:'post.show', params: { post: post.slug } }">Dettagli</router-link>
            </div>
        </div>
    </div>
</template>

<script>
import dayjs from "dayjs";

export default {
    props: {
        post: Object,
    },
    data() {
        return {};
    },
    methods: {
        formatDate(date) {
            // console.log(date);
            return dayjs(date).format('DD/MM/YYYY HH:mm');
        }
    }
};
</script>

<style scoped lang="scss">
</style>