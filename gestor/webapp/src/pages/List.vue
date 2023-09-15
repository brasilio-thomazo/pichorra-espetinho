<script setup>
import http from "axios";
import _ from "lodash";
import { onMounted, ref } from "@vue/runtime-core";
import { useRoute } from "vue-router";

const products = ref([]);
const route = useRoute();

onMounted(async () => {
  const response = await http.get(
    `${import.meta.env.VITE_API_BASEURL}/product-list/${route.params.id}`
  );
  products.value = _.sortBy(response.data, [(v) => v.name]);
});
</script>
<template>
  <div class="products">
    <div v-for="product in products" :key="product.id" class="product">
      <img :src="product.image" :alt="product.name" />
      <div class="data">
        <div class="title">{{ product.name }}</div>
        <div class="description">{{ product.description }}</div>
        <div class="prices">
          <div class="price" v-for="price in product.data" :key="price.id">
            <div class="type">{{ price.type }}</div>
            <div class="value">{{ price.price }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
