<template>
    <div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center gap-3">
                <a href="/admin/empleados" class="btn btn-secondary">
                    <i class="fa fa-arrow-left me-1"></i> Volver
                </a>
                <h2 class="mb-0">
                    <i class="fa fa-user-tie me-2"></i>Empleados — Inertia.js
                </h2>
            </div>
            <button class="btn btn-primary" @click="abrirModalCrear">
                <i class="fa fa-plus me-1"></i> Nuevo Empleado
            </button>
        </div>

        <!-- Mensaje -->
        <div v-if="mensaje" :class="`alert alert-${tipoMensaje} alert-dismissible`">
            {{ mensaje }}
            <button type="button" class="btn-close" @click="mensaje = ''"></button>
        </div>

        <!-- Tabla -->
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>DNI</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Tipo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="empleados.length === 0">
                            <td colspan="6" class="text-center text-muted py-4">
                                No hay empleados registrados.
                            </td>
                        </tr>
                        <tr v-for="empleado in empleados" :key="empleado.id">
                            <td>{{ empleado.dni ?? '-' }}</td>
                            <td>{{ empleado.nombre ?? empleado.name }}</td>
                            <td>{{ empleado.email }}</td>
                            <td>{{ empleado.telefono ?? '-' }}</td>
                            <td>
                                <span :class="empleado.tipo === 'admin'
                                    ? 'badge bg-danger'
                                    : 'badge bg-primary'">
                                    {{ empleado.tipo === 'admin' ? 'Admin' : 'Operario' }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning me-1"
                                        @click="abrirModalEditar(empleado)">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger"
                                        @click="eliminarEmpleado(empleado)">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalEmpleado" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title">
                            {{ modoEdicion ? 'Editar Empleado' : 'Nuevo Empleado' }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white"
                                data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="Object.keys(errores).length > 0"
                             class="alert alert-danger">
                            <ul class="mb-0">
                                <li v-for="(error, campo) in errores" :key="campo">
                                    {{ error[0] }}
                                </li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">DNI</label>
                                <input type="text" v-model="formulario.dni"
                                       class="form-control" placeholder="12345678A">
                            </div>
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Nombre *</label>
                                <input type="text" v-model="formulario.nombre"
                                       :class="'form-control' + (errores.nombre ? ' is-invalid' : '')"
                                       placeholder="Juan García">
                                <div v-if="errores.nombre" class="invalid-feedback">
                                    {{ errores.nombre[0] }}
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" v-model="formulario.email"
                                       :class="'form-control' + (errores.email ? ' is-invalid' : '')"
                                       placeholder="empleado@nosecaen.com">
                                <div v-if="errores.email" class="invalid-feedback">
                                    {{ errores.email[0] }}
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Teléfono</label>
                                <input type="text" v-model="formulario.telefono"
                                       class="form-control" placeholder="600000000">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    {{ modoEdicion ? 'Nueva Contraseña (dejar vacío para no cambiar)' : 'Contraseña *' }}
                                </label>
                                <input type="password" v-model="formulario.password"
                                       :class="'form-control' + (errores.password ? ' is-invalid' : '')">
                                <div v-if="errores.password" class="invalid-feedback">
                                    {{ errores.password[0] }}
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Confirmar Contraseña</label>
                                <input type="password"
                                       v-model="formulario.password_confirmation"
                                       class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tipo *</label>
                                <select v-model="formulario.tipo" class="form-select">
                                    <option value="operario">Operario</option>
                                    <option value="admin">Administrador</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary"
                                @click="guardarEmpleado" :disabled="guardando">
                            <span v-if="guardando">Guardando...</span>
                            <span v-else>
                                {{ modoEdicion ? 'Guardar Cambios' : 'Crear Empleado' }}
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const empleados = ref([]);
const mensaje = ref('');
const tipoMensaje = ref('success');
const modoEdicion = ref(false);
const empleadoEditandoId = ref(null);
const guardando = ref(false);
const errores = ref({});

const formulario = ref({
    dni: '', nombre: '', email: '', telefono: '',
    password: '', password_confirmation: '', tipo: 'operario'
});

onMounted(() => {
    cargarEmpleados();
});

async function cargarEmpleados() {
    try {
        const response = await axios.get('/admin/api/empleados');
        empleados.value = response.data;
    } catch (error) {
        mostrarMensaje('Error al cargar empleados.', 'danger');
    }
}

function abrirModalCrear() {
    modoEdicion.value = false;
    empleadoEditandoId.value = null;
    errores.value = {};
    formulario.value = {
        dni: '', nombre: '', email: '', telefono: '',
        password: '', password_confirmation: '', tipo: 'operario'
    };
    new bootstrap.Modal(document.getElementById('modalEmpleado')).show();
}

function abrirModalEditar(empleado) {
    modoEdicion.value = true;
    empleadoEditandoId.value = empleado.id;
    errores.value = {};
    formulario.value = {
        dni: empleado.dni ?? '',
        nombre: empleado.nombre ?? empleado.name,
        email: empleado.email,
        telefono: empleado.telefono ?? '',
        password: '',
        password_confirmation: '',
        tipo: empleado.tipo
    };
    new bootstrap.Modal(document.getElementById('modalEmpleado')).show();
}

async function guardarEmpleado() {
    guardando.value = true;
    errores.value = {};

    try {
        if (modoEdicion.value) {
            await axios.put(
                `/admin/api/empleados/${empleadoEditandoId.value}`,
                formulario.value
            );
            mostrarMensaje('Empleado actualizado correctamente.', 'success');
        } else {
            await axios.post('/admin/api/empleados', formulario.value);
            mostrarMensaje('Empleado creado correctamente.', 'success');
        }

        bootstrap.Modal.getInstance(
            document.getElementById('modalEmpleado')
        ).hide();

        await cargarEmpleados();

    } catch (error) {
        if (error.response?.status === 422) {
            errores.value = error.response.data.errors;
        } else {
            mostrarMensaje('Error al guardar el empleado.', 'danger');
        }
    } finally {
        guardando.value = false;
    }
}

async function eliminarEmpleado(empleado) {
    if (!confirm(`¿Seguro que quieres eliminar a ${empleado.nombre ?? empleado.name}?`)) {
        return;
    }
    try {
        await axios.delete(`/admin/api/empleados/${empleado.id}`);
        mostrarMensaje('Empleado eliminado correctamente.', 'success');
        await cargarEmpleados();
    } catch (error) {
        mostrarMensaje('Error al eliminar el empleado.', 'danger');
    }
}

function mostrarMensaje(texto, tipo) {
    mensaje.value = texto;
    tipoMensaje.value = tipo;
    setTimeout(() => { mensaje.value = ''; }, 4000);
}
</script>
