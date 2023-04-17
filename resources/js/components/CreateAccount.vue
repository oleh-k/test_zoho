<template>
    <div class="center">
        <div>
            <input type="text" v-model="name" id="name" placeholder="name">
        </div>
        <div>
            <input type="text" v-model="website" id="website" placeholder="website">
        </div>
        <div>
            <input type="text" v-model="phone" id="phone" placeholder="phone">
        </div>
        <div>
            <button @click="createAccount()" class="button">submit</button>
        </div>
        <div>
            {{ result }}
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            name: '',
            website: '',
            phone: '',
            result: '',
        }
    },
    methods: {

        createAccount () {


        }


    },
    mounted() {

    }
}
</script>