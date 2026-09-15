import { test, expect } from '@playwright/test';

test('flujo e2e completo de encuestas', async ({ page }) => {
  // 1. Ir a la pantalla de login
  await page.goto('http://127.0.0.1:8000/login');

  // 2. Llenar credenciales
  await page.getByRole('textbox', { name: /Correo/i }).fill('admin@sondar.com');
  await page.getByRole('textbox', { name: /Contrase/i }).fill('12345678');
  
  // 3. Enviar el formulario
  await page.getByRole('button', { name: /Ingresar|Iniciar/i }).click();

  // Esperar a que la pagina cambie despues del login
  await page.waitForURL('**/*', { waitUntil: 'networkidle' });

  // 4. Sección de Respuestas (ahora la página del dashboard ya cargó)
  await page.getByRole('link', { name: /Respuestas/i }).click();
  await page.getByRole('link', { name: /Ver detalle/i }).first().click();
  await page.getByRole('link', { name: /Volver/i }).click();

  // 5. Sección de Informes
  await page.getByRole('link', { name: /Informes/i }).click();

  const goToPageLink = page.getByRole('link', { name: /Go to page/i });
  if (await goToPageLink.isVisible()) {
    await goToPageLink.click();
  }

  await page.getByRole('link', { name: /Servicios/i }).click();

  // 6. Cerrar Sesión
  await page.getByRole('button', { name: /Cerrar ses/i }).click();
});