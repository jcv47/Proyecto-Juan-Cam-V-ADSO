import { test, expect } from '@playwright/test';

test('flujo completo de prueba', async ({ page }) => {
  // 1. Ir directamente a la pantalla de login
  await page.goto('http://127.0.0.1:8000/login');

  // 2. Formulario de credenciales
  await page.getByRole('textbox', { name: /Correo/i }).fill('admin@sondar.com');
  await page.getByRole('textbox', { name: /Contrase/i }).fill('12345678');
  await page.getByRole('button', { name: /Ingresar|Iniciar/i }).click();

  // 3. Navegación en el panel
  await page.getByRole('link', { name: /Respuestas/i }).click();
  await page.getByRole('link', { name: /Ver detalle/i }).first().click();
  await page.getByRole('link', { name: /Volver/i }).click();

  // 4. Informes y menú
  await page.getByRole('link', { name: /Informes/i }).click();

  const goToPageLink = page.getByRole('link', { name: /Go to page/i });
  if (await goToPageLink.isVisible()) {
    await goToPageLink.click();
  }

  await page.getByRole('link', { name: /Servicios/i }).click();

  // 5. Cerrar sesión
  await page.getByRole('button', { name: /Cerrar ses/i }).click();
});