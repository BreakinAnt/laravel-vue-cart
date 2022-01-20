<template>
    <div>
        <h4>COMMENTS:</h4>
        <b-form-select name="comment_id" v-model="commentSelected" :options="list"></b-form-select>
    </div>
</template>
<script>
export default {
    props: [
        'postId'
    ],

    data(){
        return {        
            commentSelected: null,
            list: []
        }
    },
        
    methods: {
        pluckList(list){
            return list.map((value, index) => {
                return {
                    value: value.id,
                    text: value.name
                }
            });
        }
    },

    watch: {
        async postId(val){
            const res = await axios({
                method: 'GET',
                url: `https://jsonplaceholder.typicode.com/comments?postId=${val}`
            });

            this.list = [];
            this.list = [...this.pluckList(res.data)];
            this.commentSelected = this.list[0].value;
        }
    }
}
</script>