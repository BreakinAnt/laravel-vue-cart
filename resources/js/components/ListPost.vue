<template>
    <div>
        <h4>POST:</h4>
        <b-form-select name="post_id" v-model="postSelected" :options="list"></b-form-select>
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
            list: []
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

            this.list = [...this.pluckList(res.data)];
            this.postSelected = this.list[0].value;
        }
    },

    components: {ListComment: listComment}
}
</script>