<script setup>
import http from "axios";
import _ from "lodash";
import { onMounted, ref } from "@vue/runtime-core";

const categories = ref([]);
const subcategories = ref([]);

onMounted(async () => {
  const r1 = await http.get(`${import.meta.env.VITE_API_BASEURL}/category`);
  const r2 = await http.get(`${import.meta.env.VITE_API_BASEURL}/subcategory`);

  categories.value = _.sortBy(r1.data, [(v) => v.name]);
  subcategories.value = _.sortBy(r2.data, [(v) => v.name]);
});

const getSubcategories = (id) => {
  return subcategories.value.filter((v) => v.category_id === id);
};
</script>
<template>
  <div id="menu">
    <div v-for="category in categories" :key="category.id" class="category">
      <div class="category-name">{{ category.name }}</div>
      <div class="subcategories">
        <router-link
          v-for="subcategory in getSubcategories(category.id)"
          :to="'/list/' + subcategory.id"
          class="subcategory"
          :key="subcategory.id"
        >
          <img :src="subcategory.image" :alt="subcategory.name" />
          <div class="subcategory-name">{{ subcategory.name }}</div>
        </router-link>
      </div>
    </div>
  </div>
</template>
