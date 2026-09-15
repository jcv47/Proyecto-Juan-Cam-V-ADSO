import { test, expect } from '@playwright/test';

test('validar inicio de sesion correcto', async ({ page }) => {
  // 1. Ir a la pantalla de login
  await page.goto('http://127.0.0.1:8000/login');

  // 2. Ingresar credenciales
  await page.getByRole('textbox', { name: /Correo/i }).fill('admin@sondar.com');
  await page.getByRole('textbox', { name: /Contrase/i }).fill('12345678');

  // 3. Hacer clic en Ingresar
  await page.getByRole('button', { name: /Ingresar|Iniciar/i }).click();

  // 4. Aserción final: Confirmar que ya NO estamos en la URL de /login
  await expect(page).not.toHaveURL(/.*login/);
});