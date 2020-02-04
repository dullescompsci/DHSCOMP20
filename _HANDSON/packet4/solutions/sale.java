import java.io.File;
import java.util.Scanner;

public class sale
{
    public static void main(String[] args) throws Exception
    {
        Scanner fromFile = new Scanner(new File("sale.dat"));

        double price1 = fromFile.nextDouble();
        double price2 = fromFile.nextDouble();
        double price3 = fromFile.nextDouble();

        double total = price1 + price2 + price3;
        double lowest = Math.min(Math.min(price1,price2),price3);

        double pretax = total - lowest/2;

        System.out.printf("%.2f",pretax*1.0825);
    }
}
