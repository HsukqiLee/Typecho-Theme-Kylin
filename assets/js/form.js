/* 表单处理相关JavaScript */

document.addEventListener('DOMContentLoaded', function() {
    initFormValidation();
    initFormSubmission();
    initFileUpload();
    initFormAnimations();
});

// 表单验证
function initFormValidation() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        const inputs = form.querySelectorAll('input, textarea, select');
        
        inputs.forEach(input => {
            // 实时验证
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            input.addEventListener('input', function() {
                if (this.classList.contains('error')) {
                    validateField(this);
                }
            });
        });
        
        // 表单提交验证
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            let isValid = true;
            inputs.forEach(input => {
                if (!validateField(input)) {
                    isValid = false;
                }
            });
            
            if (isValid) {
                handleFormSubmission(this);
            }
        });
    });
}

// 字段验证函数
function validateField(field) {
    const value = field.value.trim();
    const type = field.type;
    const required = field.hasAttribute('required');
    const pattern = field.getAttribute('pattern');
    const minLength = field.getAttribute('minlength');
    const maxLength = field.getAttribute('maxlength');
    
    // 清除之前的错误状态
    clearFieldError(field);
    
    // 必填验证
    if (required && !value) {
        showFieldError(field, '此字段为必填项');
        return false;
    }
    
    // 如果字段为空且非必填，跳过其他验证
    if (!value && !required) {
        return true;
    }
    
    // 邮箱验证
    if (type === 'email' && !isValidEmail(value)) {
        showFieldError(field, '请输入有效的邮箱地址');
        return false;
    }
    
    // 电话验证
    if (type === 'tel' && !isValidPhone(value)) {
        showFieldError(field, '请输入有效的电话号码');
        return false;
    }
    
    // 密码验证
    if (type === 'password' && value.length < 6) {
        showFieldError(field, '密码长度至少为6位');
        return false;
    }
    
    // 长度验证
    if (minLength && value.length < parseInt(minLength)) {
        showFieldError(field, `最少需要${minLength}个字符`);
        return false;
    }
    
    if (maxLength && value.length > parseInt(maxLength)) {
        showFieldError(field, `最多允许${maxLength}个字符`);
        return false;
    }
    
    // 正则验证
    if (pattern && !new RegExp(pattern).test(value)) {
        showFieldError(field, '输入格式不正确');
        return false;
    }
    
    // 确认密码验证
    if (field.name === 'confirmPassword') {
        const password = document.querySelector('input[name="password"]');
        if (password && value !== password.value) {
            showFieldError(field, '两次输入的密码不一致');
            return false;
        }
    }
    
    // 验证通过
    showFieldSuccess(field);
    return true;
}

// 显示字段错误
function showFieldError(field, message) {
    field.classList.add('error');
    field.classList.remove('success');
    
    // 移除旧的错误信息
    const existingError = field.parentNode.querySelector('.form-error');
    if (existingError) {
        existingError.remove();
    }
    
    // 添加新的错误信息
    const errorElement = document.createElement('div');
    errorElement.className = 'form-error';
    errorElement.textContent = message;
    field.parentNode.appendChild(errorElement);
}

// 显示字段成功
function showFieldSuccess(field) {
    field.classList.remove('error');
    field.classList.add('success');
    
    const existingError = field.parentNode.querySelector('.form-error');
    if (existingError) {
        existingError.remove();
    }
}

// 清除字段错误
function clearFieldError(field) {
    field.classList.remove('error', 'success');
    
    const existingError = field.parentNode.querySelector('.form-error');
    if (existingError) {
        existingError.remove();
    }
}

// 表单提交处理
function initFormSubmission() {
    // 这里可以添加具体的表单提交逻辑
}

function handleFormSubmission(form) {
    const formData = new FormData(form);
    const submitButton = form.querySelector('button[type="submit"]');
    
    // 显示加载状态
    if (submitButton) {
        const originalText = submitButton.textContent;
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="loading"></span> 提交中...';
        
        // 模拟表单提交
        setTimeout(() => {
            // 这里应该是实际的AJAX提交逻辑
            console.log('表单数据:', Object.fromEntries(formData));
            
            // 显示成功消息
            showFormSuccess(form, '提交成功！');
            
            // 重置按钮状态
            submitButton.disabled = false;
            submitButton.textContent = originalText;
            
            // 重置表单
            form.reset();
            form.querySelectorAll('.success').forEach(field => {
                field.classList.remove('success');
            });
            
        }, 2000);
    }
}

// 显示表单成功消息
function showFormSuccess(form, message) {
    // 移除旧的消息
    const existingAlert = form.querySelector('.alert');
    if (existingAlert) {
        existingAlert.remove();
    }
    
    // 创建成功消息
    const alertElement = document.createElement('div');
    alertElement.className = 'alert alert-success';
    alertElement.textContent = message;
    
    form.insertBefore(alertElement, form.firstChild);
    
    // 3秒后自动移除消息
    setTimeout(() => {
        alertElement.remove();
    }, 3000);
}

// 文件上传处理
function initFileUpload() {
    const fileInputs = document.querySelectorAll('.file-upload-input');
    
    fileInputs.forEach(input => {
        const label = input.nextElementSibling;
        
        input.addEventListener('change', function() {
            const files = this.files;
            if (files.length > 0) {
                const fileName = files[0].name;
                label.textContent = `已选择: ${fileName}`;
                label.style.color = 'var(--whu-primary)';
            } else {
                label.textContent = '点击选择文件或拖拽文件到此处';
                label.style.color = '';
            }
        });
        
        // 拖拽上传
        const uploadArea = input.parentNode;
        
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });
        
        uploadArea.addEventListener('dragleave', function() {
            this.classList.remove('dragover');
        });
        
        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                input.files = files;
                const event = new Event('change', { bubbles: true });
                input.dispatchEvent(event);
            }
        });
    });
}

// 表单动画
function initFormAnimations() {
    // 输入框聚焦动画
    const inputs = document.querySelectorAll('.form-control');
    
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentNode.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            if (!this.value) {
                this.parentNode.classList.remove('focused');
            }
        });
        
        // 初始化时检查是否有值
        if (input.value) {
            input.parentNode.classList.add('focused');
        }
    });
}

// 验证工具函数
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function isValidPhone(phone) {
    // 简单的中国手机号验证
    const phoneRegex = /^1[3-9]\d{9}$/;
    return phoneRegex.test(phone);
}

function isValidURL(url) {
    try {
        new URL(url);
        return true;
    } catch {
        return false;
    }
}

// 密码强度检测
function checkPasswordStrength(password) {
    let strength = 0;
    const checks = [
        password.length >= 8,
        /[a-z]/.test(password),
        /[A-Z]/.test(password),
        /[0-9]/.test(password),
        /[^A-Za-z0-9]/.test(password)
    ];
    
    strength = checks.reduce((acc, check) => acc + (check ? 1 : 0), 0);
    
    if (strength < 2) return 'weak';
    if (strength < 4) return 'medium';
    return 'strong';
}

// 显示密码强度
function showPasswordStrength(input, strength) {
    let existingIndicator = input.parentNode.querySelector('.password-strength');
    
    if (!existingIndicator) {
        existingIndicator = document.createElement('div');
        existingIndicator.className = 'password-strength';
        input.parentNode.appendChild(existingIndicator);
    }
    
    const strengthText = {
        weak: '弱',
        medium: '中',
        strong: '强'
    };
    
    existingIndicator.textContent = `密码强度: ${strengthText[strength]}`;
    existingIndicator.className = `password-strength ${strength}`;
}

// 自动保存表单数据到localStorage
function autoSaveForm(form) {
    const formId = form.id || 'default-form';
    
    // 加载保存的数据
    const savedData = localStorage.getItem(`form-${formId}`);
    if (savedData) {
        const data = JSON.parse(savedData);
        Object.keys(data).forEach(key => {
            const field = form.querySelector(`[name="${key}"]`);
            if (field) {
                field.value = data[key];
            }
        });
    }
    
    // 监听表单变化并保存
    form.addEventListener('input', debounce(function() {
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        localStorage.setItem(`form-${formId}`, JSON.stringify(data));
    }, 500));
    
    // 表单成功提交后清除保存的数据
    form.addEventListener('submit', function() {
        localStorage.removeItem(`form-${formId}`);
    });
}

// 防抖函数（如果main.js中没有定义）
if (typeof debounce === 'undefined') {
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
}