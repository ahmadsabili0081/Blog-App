<p>Dear <?= $mail_data['user']['email'] ?></p>
<p>
  Kami menerima permintaan untuk menyetel ulang sandi untuk akun BLOG_APP yang terkait dengan Email <i><?= $mail_data['user']['email'] ?></i>.
  Anda dapat mengatur ulang kata sandi Anda dengan mengklik tombol di bawah ini:
  <br><br>
  <a href="<?= $mail_data['action_link']; ?>" style="color:#fff;border-color:#22bc66; border-style: solid;border-width: 5px 10px; background-color: #22bc66; display: inline-block; text-decoration: none; border-radius: 3px; box-shadow: 0 2px 3px rgba(0,0,0,0.16); -webkit-text-size-adjust: none; box-sizing: border-box;" target="_blank">Reset Password </a>
  <br><br>

  <b>NB:</b> Tautan ini akan tetap valid dalam waktu 15 menit.
  <br><br>
  Jika Anda tidak meminta pengaturan ulang kata sandi, abaikan email ini.
</p>