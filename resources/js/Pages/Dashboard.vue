<template>
      <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <div class="flex-shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <BreezeApplicationLogo class="block h-9 w-auto" />
                                </Link>
                            </div>

                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <BreezeNavLink :href="route('home')" :active="route().current('dashboard')">
                                    Home
                                </BreezeNavLink>
                            </div>
                            
                        </div>

                        <div class="sm:flex sm:items-center sm:ml-6"  v-if="$page.props.auth.user">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <BreezeDropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <BreezeDropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </BreezeDropdownLink>
                                    </template>
                                </BreezeDropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <BreezeResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </BreezeResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200" v-if="$page.props.auth.user">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">{{ $page.props.auth.user.name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <BreezeResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </BreezeResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Dashboard
                    </h2>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <!-- slot / -->
                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white border-b border-gray-200">
                                

                                                              <div class="row">
                              <div class="col-6">
                              <h1 class="font-weight-bold"><b>IP List</b></h1>     
                              <table class="table">
                                <thead>
                                  <tr>
                                    <th scope="col">IP Address</th>
                                    <th scope="col">Label/Comment</th>
                                    <th scope="col">Edit</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr role="button" :id="'tr-'+ip.id"  :key="ip.id" v-for="ip in ips.data" :class="{ 'alert alert-dark': ip.id == current_id }">
                                    <td @click="getLabels(ip.id,ip.ip_address,ip.label)" class="text-primary"><u>{{ ip.ip_address }}</u></td>
                                    <td>{{ ip.label }} </td>
                                    <td> <button @click="edit(ip.id,ip.ip_address,ip.label)"><i class="fas fa-edit"></i></button> </td>
                                  </tr>
                                </tbody>
                              </table>
                              
                              <div v-if="$page.props.auth.user">
                              <form @submit.prevent="submit">
                                <div class="input-group input-group-sm mb-3">
                                    <input placeholder="Enter Ip Address" id="ip_address" type="text" class="form-control" v-model="form.ip_address" required autofocus :disabled="isEditMode"/>
                                    
                                    <input placeholder="Enter Label" id="label" type="text" class="form-control" v-model="form.label" required  />
                                </div>

                                <div class="mt-4">
                                    <div  v-show="isIpInvalid" class="alert alert-danger" role="alert" style="display: flex;justify-content: center;padding:2px;" >
                                        <span>Invalid IP Address</span>
                                    </div>

                                    <!-- input id="label" type="text" class="form-control" v-model="form.label" required  / -->
                                </div>
                                
                                <div class="flex items-center justify-end mt-4">
                                    <Link href="/dashboard" method="get" as="button" type="button" class="btn btn-secondary mr-2">Cancel</Link>
                                    <!-- BreezeButton class="btn btn-success" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                        Save
                                    </BreezeButton -->
                                    <button type="submit" class="btn btn-dark" >{{ isEditMode ? 'Update' : 'Add' }} </button>   
                                </div>
                            </form>
                            </div>

                              <!-- Link href="/new" method="get" as="button" type="button" class="btn btn-primary">New</Link -->
                              </div>
                              <div class="col-6">
                              <h1 class="font-weight-bold"><b>Changes History</b></h1>    

                              <table class="table">
                                <thead>
                                  <tr>
                                    <th scope="col">Action</th>
                                    <th scope="col">Label/Comment</th>
                                    <th scope="col">User</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr :key="label.id" v-for="label in labels">
                                    <td>{{ label.action }}</td>
                                    <td>{{ label.label }}</td>
                                    <td>{{ label.user.name }}</td>
                                  </tr>
                                </tbody>
                              </table>
                              </div>
                              </div>

                                


                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>


    <!-- BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        You're logged in!
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout -->
</template>

<script>
//import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue'
import BreezeDropdown from '@/Components/Dropdown.vue'
import BreezeDropdownLink from '@/Components/DropdownLink.vue'
import BreezeNavLink from '@/Components/NavLink.vue'
import BreezeResponsiveNavLink from '@/Components/ResponsiveNavLink.vue'
import { Link } from '@inertiajs/inertia-vue3';
import { Head } from '@inertiajs/inertia-vue3';

export default {
    components: {
        //BreezeAuthenticatedLayout,
        BreezeApplicationLogo,
        BreezeDropdown,
        BreezeDropdownLink,
        BreezeNavLink,
        BreezeResponsiveNavLink,
        Link,
        Head,
    },
    data() {
        return {
            showingNavigationDropdown: false,
            form: this.$inertia.form({
                ip_address: '',
                label: ''
            }),
            isIpInvalid: false,
            isEditMode: false,
            editId: '',

        }
    },
    props: {
        ips: Object,
        labels: Object,
        current_id: null
        
    },
    methods: {
      getLabels(id){
        this.$inertia.get('/dashboard/'+id);
      },
      submit() {

            if(this.isEditMode){
                this.form.put('/update/'+this.editId,{
                    onSuccess: () => {this.form.ip_address = '';this.form.label=''},
                });
                this.isEditMode = false;
            } else {

                // if(!this.form.ip_address.match(/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/g))
                // {
                //     this.isIpInvalid = true;
                //     return false;
                // }
                
                // this.form.post(this.route('store'),{
                //     onSuccess: () => {this.form.ip_address = '';this.form.label=''},
                // })
            }
        },
      edit(id,ip_address,label) {
            this.editId = id;
            let x = document.getElementsByClassName("alert-dark");
            let i;
            for (i = 0; i < x.length; i++) {
                x[i].classList.remove("alert-dark")
            }
            document.getElementById("tr-"+id).classList.add("alert-dark");
            this.form.ip_address = ip_address;
            this.form.label = label;
            this.isEditMode = true;
              
        }  

    },
    created() {
        
        //this.labels = this.ips.data

        console.log(this.labels);
    }
}
</script>
