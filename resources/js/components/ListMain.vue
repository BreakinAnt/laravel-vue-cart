<template>
    <div class="flex-center" style="background-color: #88c2df; color: #000000">
        <h4>USERS:</h4>
        <b-form-select name="user_id" v-model="userSelected" :options="list"></b-form-select>
        <listPost :userId="userSelected"></listPost>
    </div>
</template>
<script>
import ListPost from './ListPost.vue';

export default {
    data() { 
        return {
            userSelected: null,
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

    async created() {
        const res = await axios({
            method: 'GET',
            url: 'https://jsonplaceholder.typicode.com/users'
        });

        this.list = [...this.pluckList(res.data)];
        this.userSelected = this.list[0].value;
    },

    components: {listPost: ListPost}
}
</script>