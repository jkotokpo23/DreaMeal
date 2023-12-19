

import com.google.zxing.BinaryBitmap;
import com.google.zxing.LuminanceSource;
import com.google.zxing.MultiFormatReader;
import com.google.zxing.NotFoundException;
import com.google.zxing.Result;
import com.google.zxing.client.j2se.BufferedImageLuminanceSource;
import com.google.zxing.common.HybridBinarizer;
import java.awt.image.BufferedImage;
import java.io.IOException;

public class QRcodeReader {

    private static String decodeQRCode1(BufferedImage bufferedImage) throws IOException {
        LuminanceSource source = new BufferedImageLuminanceSource(bufferedImage);
        BinaryBitmap bitmap = new BinaryBitmap(new HybridBinarizer(source));
        try {
            Result result = new MultiFormatReader().decode(bitmap);
            return result.getText();
        } catch (NotFoundException e) {
            return null;
        }
    }

     public static String Ref(BufferedImage path){
        String result = null;
        try {
            String decodedText = decodeQRCode1(path);
            if(decodedText != null) {
                result = decodedText;
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
        return result;
    }
}
