import { test, expect } from '@playwright/test';

test('flujo e2e completo de encuestas', async ({ page }) => {
  // 1. Ir directamente a la vista de login
  await page.goto('http://127.0.0.1:8000/login');

  // 2. Llenar credenciales
  await page.getByRole('textbox', { name: /Correo/i }).fill('admin@sondar.com');
  await page.getByRole('textbox', { name: /Contrase/i }).fill('12345678');
  
  // 3. Enviar formulario
  await page.getByRole('button', { name: /Ingresar|Iniciar/i }).click();

  // 4. Esperar a estar fuera de la pagina de login (redirección completada)
  await page.waitForURL((url) => !url.pathname.includes('/login'), { timeout: 15000 });

  // 5. Navegar a Respuestas buscando por texto amplio
  await page.locator('a', { hasText: /Respuestas/i }).click();
  await page.locator('a', { hasText: /Ver detalle/i }).first().click();
  await page.locator('a', { hasText: /Volver/i }).click();

  // 6. Navegar a Informes
  await page.locator('a', { hasText: /Informes/i }).click();

  const goToPageLink = page.locator('a', { hasText: /Go to page/i });
  if (await goToPageLink.isVisible()) {
    await goToPageLink.click();
  }

  await page.locator('a', { hasText: /Servicios/i }).click();

  // 7. Cerrar Sesión
  await page.getByRole('button', { name: /Cerrar ses/i }).click();
});