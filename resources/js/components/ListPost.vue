<template>
    <div>
        <h4>POST:</h4>
        <b-form-select v-model="postSelected" :options="list"></b-form-select>
        <listComment :postId="postSelected"></listComment>
    </div>
</template>
<script>
import listComment from './ListComment.vue';

export default {
    props: [
        'userId'
    ],

    data(){
        return {        
            postSelected: null,
            list: [{ value: null, text: 'Select a post' }]
        }
    },
        
    methods: {
        pluckList(list){
            return list.map((value, index) => {
                return {
                    value: value.id,
                    text: value.title
                }
            });
        }
    },

    watch: {
        async userId(val){
            const res = await axios({
                method: 'GET',
                url: `https://jsonplaceholder.typicode.com/posts?userId=${val}`
            });

            this.list = [];
            this.list = [{ value: null, text: 'Select a post' }, ...this.pluckList(res.data)];
        }
    },

    components: {ListComment: listComment}
}
</script>