<template>    
    <div class="flex-center" style="background-color: #88c2df; color: #000000">
        <p>Carrinho</p>
        <ul>
            <li v-for="(item, index) in items" v-bind:key="item.id">
                <div v-if="!item.loaded">
                    <b-spinner label="Spinning"></b-spinner>
                </div>
                <div v-else>
                    <p><b>{{item.name}}</b></p>
                    <p>Valor: {{priceToString(item.value)}}</p>
                    <p>Quant.: {{item.quant}} <button v-on:click="changeQnt(index, 1)">+</button><button v-on:click="changeQnt(index, 0)">-</button></p>
                    <form :action="deleteRoute" method="GET">
                        <input type="hidden" name="id" :value="item.id">
                        <input type="hidden" name="index" :value="index">
                        <button v-if="item.quant == 0" type="submit">REMOVER</button>
                    </form>
                </div>
            </li>
            <div>
                <h4><b>Valor total:</b> {{priceToString(totalValue)}}</h4>
                <form :action="checkoutRoute" method="POST">
                    <input type="hidden" name="_token" :value="csrf">
                    <input type="hidden" name="totalValue" :value="totalValue">
                    <div v-for="(item, index) in items" v-bind:key="item.id">
                         <input type="hidden" :name="`products[${index}][id]`" :value="item.id">
                         <input type="hidden" :name="`products[${index}][quant]`" :value="item.quant">
                    </div>
                    <button v-if="totalValue > 0" type="submit">COMPRAR</button>
                </form>
            </div>
        </ul>
    </div>
</template>
<script>
export default {
    props:{
        'cookie': String,
        'delete-route': String,
        'checkout-route': String,
        'csrf': String
    },

    data() {
        return {
            items: [],
            totalValue: 0
        }
    },

    methods: {
        getCookie(){
            return JSON.parse(this.cookie);
        },

        priceToString(value){
            let price = 'Calculando...';
            if(!isNaN(value)){
                price = (value / 100).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
            }

            return price;
        },

        cartToJson(){
            return JSON.stringify(this.items);
        },

        changeQnt(index, action){
            const prod = this.items[index];
            switch(action){
                case 0: //sub
                    prod.quant--;
                break;
                case 1: //sum
                    prod.quant++;
                break;
            }

            if(prod.quant < 0){
                prod.quant = 0;
            }

            this.sumTotal();
        },

        sumTotal(){
            this.totalValue = 0;
            this.items.forEach(prod => {
                this.totalValue += prod.value * prod.quant;
            });
        }
    },

    async created() {
        console.log(this.getCookie());
        this.items = this.getCookie();

        this.items.forEach(async (product, index) => {
            const res = await axios({
                method: 'get',
                url: 'http://localhost:8000/api/product',
                params: {'id': product.id}
            });

            let fetchedProd = res.data.product;
            fetchedProd.quant = product.quant;
            fetchedProd.loaded = true;

            this.items[index] = fetchedProd;

            this.sumTotal();
       });

    }
};
</script>