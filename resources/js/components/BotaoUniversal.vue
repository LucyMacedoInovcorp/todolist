<!-- Componente universal para todos os tipos de botões da aplicação -->
<template>
    <component 
        :is="elementType"
        :type="elementType === 'button' ? type : undefined"
        :href="elementType === 'a' ? '#' : undefined"
        :class="classes"
        :title="titulo"
        :disabled="disabled"
        @click="handleClick"
    >
        <img 
            v-if="icone" 
            :src="icone" 
            :alt="altIcone" 
            class="w-3 h-3" 
            :class="{ 'mr-2': $slots.default && !apenasIcone, 'icon-destaque': apenasIcone }"
        >
        <slot v-if="!apenasIcone"></slot>
    </component>
</template>

<script>
export default {
    name: 'BotaoUniversal',
    props: {
        // Tipo do elemento HTML
        type: {
            type: String,
            default: 'button'
        },
        // Estilo do botão
        variante: {
            type: String,
            default: 'primary',
            validator: value => [
                'primary', 'secondary', 'success', 'danger', 'warning', 'bottom',
                'subtle-success', 'subtle-danger',
                'default', 'editar', 'excluir'
            ].includes(value)
        },
        // Tamanho do botão
        tamanho: {
            type: String,
            default: 'normal',
            validator: value => ['small', 'normal', 'large'].includes(value)
        },
        // Ícone do botão
        icone: {
            type: String,
            default: ''
        },
        // Alt text do ícone
        altIcone: {
            type: String,
            default: 'Ícone'
        },
        // Tooltip do botão
        titulo: {
            type: String,
            default: ''
        },
        // Estado desabilitado
        disabled: {
            type: Boolean,
            default: false
        },
        // Apenas ícone (sem texto)
        apenasIcone: {
            type: Boolean,
            default: false
        }
    },
    emits: ['click'],
    computed: {
        elementType() {
            return this.apenasIcone ? 'a' : 'button';
        },
        
        classes() {
            if (this.apenasIcone) {
                return this.getIconeClasses();
            } else {
                return this.getBotaoClasses();
            }
        }
    },
    methods: {
        handleClick(event) {
            if (this.apenasIcone) {
                event.preventDefault();
            }
            this.$emit('click', event);
        },
        
        getBotaoClasses() {
            const baseClasses = ['botao-universal'];
            
            // Variantes para botões com texto
            const variantClasses = {
                primary: 'botao-primary',
                secondary: 'botao-secondary', 
                success: 'botao-success',
                danger: 'botao-danger',
                warning: 'botao-warning',
                bottom: 'botao-bottom',
                'subtle-success': 'botao-subtle-success',
                'subtle-danger': 'botao-subtle-danger'
            };
            
            // Tamanhos
            const sizeClasses = {
                small: 'botao-small',
                normal: '',
                large: 'botao-large'
            };
            
            return [
                ...baseClasses,
                variantClasses[this.variante] || variantClasses.primary,
                sizeClasses[this.tamanho],
                { 'botao-disabled': this.disabled }
            ].filter(Boolean);
        },
        
        getIconeClasses() {
            const baseClasses = ['botao-icone'];
            
            const variantClasses = {
                default: 'icone-default',
                primary: 'icone-primary',
                editar: 'icone-editar',
                excluir: 'icone-excluir',
                success: 'icone-success',
                warning: 'icone-warning'
            };
            
            return [
                ...baseClasses,
                variantClasses[this.variante] || variantClasses.default,
                { 'icone-disabled': this.disabled }
            ].filter(Boolean);
        }
    }
}
</script>

<style scoped>
/* Estilos base */
.botao-universal {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
    outline: none;
    text-decoration: none;
}

.botao-icone {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.25rem;
    border-radius: 4px;
    transition: all 0.2s;
    text-decoration: none;
    cursor: pointer;
}

/* Variantes para botões com texto */
.botao-primary {
    background-color: #3b82f6;
    color: white;
}

.botao-primary:hover:not(.botao-disabled) {
    background-color: #2563eb;
}

.botao-secondary {
    background-color: #6b7280;
    color: white;
}

.botao-secondary:hover:not(.botao-disabled) {
    background-color: #4b5563;
}

.botao-success {
    background-color: #10b981;
    color: white;
}

.botao-success:hover:not(.botao-disabled) {
    background-color: #059669;
}

.botao-danger {
    background-color: #ef4444;
    color: white;
}

.botao-danger:hover:not(.botao-disabled) {
    background-color: #dc2626;
}

.botao-warning {
    background-color: #fef3c7;
    color: #92400e;
    border: 1px solid #f3e8ff;
}

.botao-warning:hover:not(.botao-disabled) {
    background-color: #fde68a;
    color: #78350f;
    border-color: #e5e7eb;
}

.botao-bottom {
    width: 100%;
    background-color: #dbeafe;
    color: #1e40af;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    border: 1px solid #bfdbfe;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.botao-bottom:hover:not(.botao-disabled) {
    background-color: #bfdbfe;
    color: #1d4ed8;
    transform: translateY(-1px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-color: #93c5fd;
}

.botao-subtle-success {
    background-color: transparent;
    color: #10b981;
    border: 1px solid #d1fae5;
}

.botao-subtle-success:hover:not(.botao-disabled) {
    background-color: #f0fdf4;
    color: #059669;
    border-color: #a7f3d0;
}

.botao-subtle-danger {
    background-color: transparent;
    color: #ef4444;
    border: 1px solid #fecaca;
}

.botao-subtle-danger:hover:not(.botao-disabled) {
    background-color: #fef2f2;
    color: #dc2626;
    border-color: #fca5a5;
}

/* Tamanhos */
.botao-small {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.botao-large {
    padding: 0.75rem 1.5rem;
    font-size: 1.125rem;
}

/* Variantes para botões apenas com ícone */
.botao-icone:hover:not(.icone-disabled) {
    background-color: rgba(0, 0, 0, 0.05);
    transform: scale(1.1);
}

.icone-default {
    color: #6b7280;
}

.icone-default:hover:not(.icone-disabled) {
    color: #374151;
}

.icone-primary {
    color: #3b82f6;
}

.icone-primary:hover:not(.icone-disabled) {
    color: #2563eb;
    background-color: rgba(59, 130, 246, 0.1);
}

.icone-editar {
    color: #3b82f6;
}

.icone-editar:hover:not(.icone-disabled) {
    color: #2563eb;
    background-color: rgba(59, 130, 246, 0.1);
}

.icone-excluir {
    color: #ef4444;
}

.icone-excluir:hover:not(.icone-disabled) {
    color: #dc2626;
    background-color: rgba(239, 68, 68, 0.1);
}

.icone-success {
    color: #10b981;
}

.icone-success:hover:not(.icone-disabled) {
    color: #059669;
    background-color: rgba(16, 185, 129, 0.1);
}

.icone-warning {
    color: #f59e0b;
}

.icone-warning:hover:not(.icone-disabled) {
    color: #d97706;
    background-color: rgba(245, 158, 11, 0.1);
}

/* Estados desabilitados */
.botao-disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.icone-disabled {
    opacity: 0.5;
    cursor: not-allowed;
    pointer-events: none;
}

/* Ícone com destaque */
.icon-destaque {
    transition: all 0.2s;
}
</style>