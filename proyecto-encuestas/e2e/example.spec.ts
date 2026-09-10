import { test, expect } from '@playwright/test';

test('test', async ({ page }) => {
  await page.goto('http://127.0.0.1:8000/');
  await page.getByText('Sondar: Innovación a tu Alcance Transformamos tus ideas en realidad digital con').click();
  await page.getByRole('link', { name: 'Iniciar Sesión' }).click();
  await page.getByRole('textbox', { name: 'Correo:' }).click();
  await page.getByRole('textbox', { name: 'Correo:' }).fill('admin');
  await page.getByRole('textbox', { name: 'Correo:' }).press('Alt+@');
  await page.getByRole('textbox', { name: 'Correo:' }).fill('admin@sondar.com');
  await page.getByRole('textbox', { name: 'Contraseña:' }).click();
  await page.getByRole('textbox', { name: 'Contraseña:' }).press('CapsLock');
  await page.getByRole('textbox', { name: 'Contraseña:' }).fill('12345678');
  await page.getByRole('button', { name: 'Ingresar' }).click();
  await page.getByRole('link', { name: 'Respuestas' }).click();
  await page.getByRole('link', { name: 'Ver detalle' }).first().click();
  await page.getByRole('link', { name: 'Volver' }).click();
  await page.getByRole('link', { name: 'Informes' }).click();
  await page.getByRole('link', { name: 'Go to page' }).click();
  await page.getByRole('link', { name: 'Servicios' }).click();
  await page.getByRole('button', { name: 'Cerrar sesión' }).click();
});