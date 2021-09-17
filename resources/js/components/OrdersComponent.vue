<template>
    <div>
        <table class="list">
            <tr>
                <th>Nr</th>
                <th>Date</th>
                <th>Contact Details</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
            <tr v-for="order in orders" :key="order.id">
                <td>{{ order.id }}</td>
                <td>{{ order.created_at }}</td>
                <td>
                  <table>
                      <tr>
                          <td>Name</td>
                          <td>{{ order.name }}</td>
                      </tr>
                      <tr>
                          <td>Contact Details</td>
                          <td>{{ order.contact_details }}</td>
                      </tr>
                      <tr>
                          <td>Comment</td>
                          <td>{{ order.comment ? order.comment : '' }}</td>
                      </tr>
                  </table>
                </td>
                <td>{{ order.total }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <router-link :to="{ name: 'vue.order', params: { id: order.id }}">Details</router-link>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                orders: []
            }
        },
        created() {
            this.axios
                .get('http://localhost:8000/orders')
                .then(response => {
                    this.orders = response.data;
                });
        }
    }
</script>