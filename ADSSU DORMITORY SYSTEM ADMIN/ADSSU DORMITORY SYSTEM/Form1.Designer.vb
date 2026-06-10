<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()>
Partial Class Form1
    Inherits System.Windows.Forms.Form

    'Form overrides dispose to clean up the component list.
    <System.Diagnostics.DebuggerNonUserCode()>
    Protected Overrides Sub Dispose(disposing As Boolean)
        Try
            If disposing AndAlso components IsNot Nothing Then
                components.Dispose()
            End If
        Finally
            MyBase.Dispose(disposing)
        End Try
    End Sub

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.IContainer

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()>
    Private Sub InitializeComponent()
        components = New System.ComponentModel.Container()
        TableLayoutPanel1 = New TableLayoutPanel()
        PanelLogin = New Panel()
        btnLogin = New Button()
        txtPassword = New TextBox()
        lblPassword = New Label()
        txtUsername = New TextBox()
        lblUsername = New Label()
        lblTitle = New Label()
        TableLayoutPanel1.SuspendLayout()
        PanelLogin.SuspendLayout()
        SuspendLayout()
        ' 
        ' TableLayoutPanel1
        ' 
        TableLayoutPanel1.ColumnCount = 3
        TableLayoutPanel1.ColumnStyles.Add(New ColumnStyle(SizeType.Percent, 50.0F))
        TableLayoutPanel1.ColumnStyles.Add(New ColumnStyle(SizeType.Absolute, 450.0F))
        TableLayoutPanel1.ColumnStyles.Add(New ColumnStyle(SizeType.Percent, 50.0F))
        TableLayoutPanel1.Controls.Add(PanelLogin, 1, 1)
        TableLayoutPanel1.Dock = DockStyle.Fill
        TableLayoutPanel1.Location = New Point(0, 0)
        TableLayoutPanel1.Name = "TableLayoutPanel1"
        TableLayoutPanel1.RowCount = 3
        TableLayoutPanel1.RowStyles.Add(New RowStyle(SizeType.Percent, 50.0F))
        TableLayoutPanel1.RowStyles.Add(New RowStyle(SizeType.Absolute, 400.0F))
        TableLayoutPanel1.RowStyles.Add(New RowStyle(SizeType.Percent, 50.0F))
        TableLayoutPanel1.Size = New Size(800, 450)
        TableLayoutPanel1.TabIndex = 0
        ' 
        ' PanelLogin
        ' 
        PanelLogin.BackColor = Color.FromArgb(30, 41, 59)
        PanelLogin.BorderStyle = BorderStyle.None
        PanelLogin.Controls.Add(btnLogin)
        PanelLogin.Controls.Add(txtPassword)
        PanelLogin.Controls.Add(lblPassword)
        PanelLogin.Controls.Add(txtUsername)
        PanelLogin.Controls.Add(lblUsername)
        PanelLogin.Controls.Add(lblTitle)
        PanelLogin.Dock = DockStyle.Fill
        PanelLogin.Location = New Point(203, 53)
        PanelLogin.Name = "PanelLogin"
        PanelLogin.Size = New Size(394, 344)
        PanelLogin.TabIndex = 0
        ' 
        ' btnLogin
        ' 
        btnLogin.BackColor = Color.FromArgb(79, 70, 229)
        btnLogin.Cursor = Cursors.Hand
        btnLogin.FlatAppearance.BorderSize = 0
        btnLogin.FlatStyle = FlatStyle.Flat
        btnLogin.Font = New Font("Segoe UI", 12F, FontStyle.Bold, GraphicsUnit.Point, CByte(0))
        btnLogin.ForeColor = Color.White
        btnLogin.Location = New Point(40, 280)
        btnLogin.Name = "btnLogin"
        btnLogin.Size = New Size(370, 48)
        btnLogin.TabIndex = 5
        btnLogin.Text = "SIGN IN"
        btnLogin.UseVisualStyleBackColor = False
        ' 
        ' txtPassword
        ' 
        txtPassword.BackColor = Color.FromArgb(51, 65, 85)
        txtPassword.BorderStyle = BorderStyle.FixedSingle
        txtPassword.Font = New Font("Segoe UI", 12F, FontStyle.Regular, GraphicsUnit.Point, CByte(0))
        txtPassword.ForeColor = Color.White
        txtPassword.Location = New Point(40, 205)
        txtPassword.Name = "txtPassword"
        txtPassword.PasswordChar = "*"c
        txtPassword.Size = New Size(370, 29)
        txtPassword.TabIndex = 4
        ' 
        ' lblPassword
        ' 
        lblPassword.AutoSize = True
        lblPassword.Font = New Font("Segoe UI", 10F, FontStyle.Bold, GraphicsUnit.Point, CByte(0))
        lblPassword.ForeColor = Color.FromArgb(148, 163, 184)
        lblPassword.Location = New Point(36, 180)
        lblPassword.Name = "lblPassword"
        lblPassword.Size = New Size(73, 19)
        lblPassword.TabIndex = 3
        lblPassword.Text = "PASSWORD"
        ' 
        ' txtUsername
        ' 
        txtUsername.BackColor = Color.FromArgb(51, 65, 85)
        txtUsername.BorderStyle = BorderStyle.FixedSingle
        txtUsername.Font = New Font("Segoe UI", 12F, FontStyle.Regular, GraphicsUnit.Point, CByte(0))
        txtUsername.ForeColor = Color.White
        txtUsername.Location = New Point(40, 130)
        txtUsername.Name = "txtUsername"
        txtUsername.Size = New Size(370, 29)
        txtUsername.TabIndex = 2
        ' 
        ' lblUsername
        ' 
        lblUsername.AutoSize = True
        lblUsername.Font = New Font("Segoe UI", 10F, FontStyle.Bold, GraphicsUnit.Point, CByte(0))
        lblUsername.ForeColor = Color.FromArgb(148, 163, 184)
        lblUsername.Location = New Point(36, 105)
        lblUsername.Name = "lblUsername"
        lblUsername.Size = New Size(89, 19)
        lblUsername.TabIndex = 1
        lblUsername.Text = "ADMIN EMAIL"
        ' 
        ' lblTitle
        ' 
        lblTitle.Dock = DockStyle.Top
        lblTitle.Font = New Font("Segoe UI", 18F, FontStyle.Bold, GraphicsUnit.Point, CByte(0))
        lblTitle.ForeColor = Color.White
        lblTitle.Location = New Point(0, 0)
        lblTitle.Name = "lblTitle"
        lblTitle.Padding = New Padding(0, 35, 0, 0)
        lblTitle.Size = New Size(392, 85)
        lblTitle.TabIndex = 0
        lblTitle.Text = "ADSSU ADMIN PORTAL"
        lblTitle.TextAlign = ContentAlignment.TopCenter
        ' 
        ' Form1
        ' 
        AutoScaleDimensions = New SizeF(7.0F, 15.0F)
        AutoScaleMode = AutoScaleMode.Font
        BackColor = Color.FromArgb(15, 23, 42)
        ClientSize = New Size(800, 450)
        Controls.Add(TableLayoutPanel1)
        Name = "Form1"
        Text = "ADSSU Dormitory System - Admin Login"
        WindowState = FormWindowState.Maximized
        TableLayoutPanel1.ResumeLayout(False)
        PanelLogin.ResumeLayout(False)
        PanelLogin.PerformLayout()
        ResumeLayout(False)
    End Sub

    Friend WithEvents TableLayoutPanel1 As TableLayoutPanel
    Friend WithEvents PanelLogin As Panel
    Friend WithEvents lblTitle As Label
    Friend WithEvents txtUsername As TextBox
    Friend WithEvents lblUsername As Label
    Friend WithEvents txtPassword As TextBox
    Friend WithEvents lblPassword As Label
    Friend WithEvents btnLogin As Button

End Class
