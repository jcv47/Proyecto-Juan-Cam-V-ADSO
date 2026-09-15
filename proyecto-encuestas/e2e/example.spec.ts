import { test, expect } from '@playwright/test';

test('test', async ({ page }) => {
  // 1. Ir a la raiz
  await page.goto('http://127.0.0.1:8000/');

  // 2. Usar regex para no depender de tildes o mayúsculas en 'Iniciar Sesión'
  await page.getByRole('link', { name: /Iniciar Ses/i }).click();

  // 3. Llenar el formulario directo sin clics intermedios de codegen
  await page.getByRole('textbox', { name: /Correo/i }).fill('admin@sondar.com');
  await page.getByRole('textbox', { name: /Contrase/i }).fill('12345678');
  
  await page.getByRole('button', { name: /Ingresar|Iniciar/i }).click();
});