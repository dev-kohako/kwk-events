<mjml>
  <mj-head>
    <mj-title>Redefinição de Senha</mj-title>
    <mj-preview>Use o link para redefinir sua senha. Expira em 60 minutos.</mj-preview>
    <mj-attributes>
      <mj-all font-family="Helvetica Neue, Arial, sans-serif" />
      <mj-text font-size="16px" line-height="1.5" color="#374151" />
      <mj-button background-color="#3b82f6" color="white" font-size="16px" font-weight="bold" border-radius="6px" padding="16px 32px" />
    </mj-attributes>
    <mj-style inline="inline">
      .footer {
        font-size: 12px;
        color: #9ca3af;
      }
    </mj-style>
  </mj-head>

  <mj-body background-color="#f9fafb">
    <mj-section padding="32px 0">
      <mj-column width="100%">
        <mj-text align="center" font-size="24px" font-weight="bold" color="#111827">
          Redefinição de Senha
        </mj-text>
        <mj-divider border-color="#e5e7eb" />
      </mj-column>
    </mj-section>

    <mj-section background-color="#ffffff" border-radius="8px" padding="32px">
      <mj-column>
        <mj-text font-size="18px" font-weight="bold" color="#111827">
          Olá {{ $user->name }},
        </mj-text>

        <mj-text>
          Recebemos uma solicitação para redefinir a senha da sua conta. Clique no botão abaixo para continuar. Este link expirará em 60 minutos.
        </mj-text>

        <mj-button href="{{ $url }}">
          Redefinir Senha
        </mj-button>

        <mj-text color="#6b7280" font-size="14px" padding-top="16px">
          Se você não solicitou essa alteração, pode ignorar este e-mail com segurança.
        </mj-text>
      </mj-column>
    </mj-section>

    <mj-section padding="24px 0">
      <mj-column>
        <mj-divider border-color="#e5e7eb" />
        <mj-text align="center" css-class="footer">
          {{ config('app.name') }}<br/>
          &copy; {{ now()->year }} Todos os direitos reservados.
        </mj-text>
      </mj-column>
    </mj-section>
  </mj-body>
</mjml>
