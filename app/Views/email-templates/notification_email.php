<p>Dear <b><?= $mail_data['user']['name']; ?></b></p>
<br>
<p>
  Kata Sandi Anda di Sistem Aplikasi Blog berhasil diubah. Ini adalah kredensial login baru Anda:
  <br><br>
  <b>Login ID : </b><?= $mail_data['user']['username']; ?> atau <?= $mail_data['user']['email']; ?>
  <br>
  <b>Password : </b><?= $mail_data['password']; ?>
</p>

<br><br>
Tolong, simpan kredensial Anda. Nama pengguna dan kata sandi Anda adalah kredensial Anda sendiri dan Anda tidak boleh membagikannya
dengan orang lain.
<p>
  Aplikasi Blog tidak bertanggung jawab atas penyalahgunaan nama pengguna atau kata sandi Anda.
</p>
<br>
-------------------------------------------------------------------
<p>Email ini dikirim secara otomatis oleh sistem Aplikasi Blog. Jangan membalasnya.</p>