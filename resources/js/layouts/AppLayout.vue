<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <i class="fa fa-elevator me-2"></i>Nosecaen
                </a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/tareas">
                                <i class="fa fa-list me-1"></i> Tareas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/clientes">
                                <i class="fa fa-users me-1"></i> Clientes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/empleados-inertia">
                                <i class="fa fa-user-tie me-1"></i> Empleados
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/cuotas">
                                <i class="fa fa-file-invoice-dollar me-1"></i> Cuotas
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container mt-4">
            <slot />
        </div>
    </div>
</template>

<script setup>
</script>