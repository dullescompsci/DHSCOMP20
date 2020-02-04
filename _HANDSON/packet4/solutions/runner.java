import java.io.File;
import java.util.Scanner;

public class runner
{
    public static final int FEET_IN_A_MILE = 5280;

    public static void main(String[] args) throws Exception
    {
        Scanner fromFile = new Scanner(new File("runner.dat"));

        long totalFeet = 0;
        long totalRunMinutes = 0;
        for(int x=0; x<5; x++)
        {
            totalFeet+=fromFile.nextLong();
            totalRunMinutes+=fromFile.nextLong();
        }

        //System.out.println(totalFeet + " " +totalRunMinutes);
        double milesPerHour = ((double)totalFeet/FEET_IN_A_MILE)/((double)totalRunMinutes/60);

        System.out.printf("Your speed was %.3f miles per hour.",milesPerHour);
    }
}
