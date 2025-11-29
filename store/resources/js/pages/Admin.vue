<template>
  <div class="admin-page">
    <h1>Admin Dashboard</h1>

    <!-- Один обработчик на весь блок -->
    <div @click="handleClick" class="categories-container">
      <div v-for="(products, catName) in mapa" :key="catName" class="category-block">
        <h3>{{ catName }}</h3><button class="delete-cat" :data-id="cat_list[catName]" >delete cat</button>

        <ul>
          <li v-for="product in products" :key="product.id">
            {{ product.name }} — ${{ product.price }}<br>
            <p v-if="product.stock === 0">Is absent</p>
            <p v-else>Stock: {{ product.stock }}</p>
            <p>{{ product.description }}</p>

            <!-- data-атрибут с id продукта -->
            <button class="delete-prod" :data-id="product.id">Delete</button>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    mapa: Object,
    cat_list:Object
  },
  data(){
    return {
      handlers:{}
    }
  },
  created(){
    this.handlers = {
      "delete-prod":this.deleteprod,
      "delete-cat":this.deletecat,
    }
  },
  methods: {
     handleClick(event) {
      let btn = event.target.closest("button");
      if(!btn) return;
     let h =  this.handlers[btn.className];
      if(h){
        h(btn);
      }

      
    },
    async deleteprod(btn){
         const productId = btn.dataset.id;
      console.log("Удаляем продукт с id:", productId);

      try {
        // DELETE запрос на Laravel роут
        const response = await fetch(`api/products/${productId}`, {
          method: 'DELETE',
          headers: {
            'Content-Type': 'application/json',
          }
        });

        if (!response.ok) throw new Error('Ошибка удаления');

        // Если успех, удаляем локально из mapa для мгновенного обновления UI
        for (const cat in this.mapa) {
          this.mapa[cat] = this.mapa[cat].filter(p => p.id != productId);
        }

        console.log('Продукт удалён успешно');
      } catch (error) {
        console.error(error);
      }
    },
    async deletecat(btn){
       const productId = btn.dataset.id;
      console.log("Удаляем cat с id:", productId);

      try {
        // DELETE запрос на Laravel роут
        const response = await fetch(`api/categories/${productId}`, {
          method: 'DELETE',
          headers: {
            'Content-Type': 'application/json',
          }
        });

        if (!response.ok) throw new Error('Ошибка удаления');

        // Если успех, удаляем локально из mapa для мгновенного обновления UI
        for (const cat in this.mapa) {
          this.mapa[cat] = this.mapa[cat].filter(p => p.id != productId);
        }

        console.log('Продукт удалён успешно');
      } catch (error) {
        console.error(error);
      }
    }
  }
}
</script>
